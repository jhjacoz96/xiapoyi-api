<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artisan;
use Log;
use Session;
use Illuminate\Support\Facades\Storage;
use App\Utils\Enums\EnumResponse;

class BackupController extends Controller
{
    public function listBackup ($selectDisk) {
       $dir = $selectDisk == 'dropbox' ? 'dropbox' : config('backup.destination.disks');
       $disk = Storage::disk($dir);
       $files = $disk->files('/Laravel/');
       $backups = [];
       foreach ($files as $k => $f) {
           if (substr($f, -4) == '.zip' && $disk->exists($f)) {
               $backups[] = [
               'file_path' => $f,
               'file_name' => str_replace($dir . '/Laravel/', '', $f),
               'file_size' => $this->humanFileSize($disk->size($f)),
               'last_modified' => $disk->lastModified($f),
                ];
           }
        }
        $data = array_reverse($backups);
        return $data;
    }

    public function index(Request $request){
        try {
            $data = $this->listBackup($request["select_disk"]);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }        
    }

    public function indexDropbox(){
        try {
            $disk = Storage::disk('dropbox');
            $files = $disk->files('/Laravel/');
            // $files = $disk->files(config('backup.name'));
            $backups = [];
            foreach ($files as $k => $f) {
               if (substr($f, -4) == '.zip' && $disk->exists($f)) {
                   $backups[] = [
                   'file_path' => $f,
                   'file_name' => str_replace(config('backup.destination.disks') . '/Laravel/', '', $f),
                   'file_size' => $this->humanFileSize($disk->size($f)),
                   'last_modified' => $disk->lastModified($f),
                    ];
               }
            }
            $data = array_reverse($backups);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }        
    }



    public static function humanFileSize($size,$unit="") {
          if( (!$unit && $size >= 1<<30) || $unit == "GB")
               return number_format($size/(1<<30),2)."GB";
          if( (!$unit && $size >= 1<<20) || $unit == "MB")
               return number_format($size/(1<<20),2)."MB";
          if( (!$unit && $size >= 1<<10) || $unit == "KB")
               return number_format($size/(1<<10),2)."KB";
          return number_format($size)." bytes";
    }

    public function store()
    {
          try {
               /* only database backup*/
              Artisan::call('backup:run --only-db');
               /* all backup */
               /* Artisan::call('backup:run'); */
               $output = Artisan::output();
               Log::info("Backpack\BackupManager -- new backup started \r\n" . $output);
               $data = [
                    'message' => __('response.response_post_success_long')
                ];
               return bodyResponseRequest(EnumResponse::SUCCESS, $data);
          } catch (Exception $e) {
            return $e;
          }
    }

     public function download(Request $request, $file_name) {
        try {
            $selectDisk = $request["select_disk"];
            $dir = $selectDisk == 'dropbox' ? 'dropbox' : config('backup.destination.disks');
            $disk = Storage::disk($dir);
            $file = $selectDisk == 'dropbox' ? 'Laravel/'. $file_name : config('backup.destination.disks') .'/Laravel/'. $file_name;
            if ($disk->exists($file)) {
                $fs = Storage::disk($dir)->getDriver();
                $stream = $fs->readStream($file);

                return \Response::stream(function () use ($stream) {
                    fpassthru($stream);
                }, 200, [
                    "Content-Type" => $fs->getMimetype($file),
                    "Content-Length" => $fs->getSize($file),
                    "Content-disposition" => "attachment; filename=\"" . basename($file) . "\"",
                ]);
            } else {
                $data = [
                    'message' => __('response.bad_request_long')
                ];
                return bodyResponseRequest(EnumResponse::NOT_FOUND, $data);
            }   
        } catch (Exception $e) {
            return $e;   
        }
    }

    public function downloadDropbox($file_name) {
        try {
            $file = 'Laravel/'. $file_name;
            $disk = Storage::disk('dropbox');

            if ($disk->exists($file)) {
                $fs = Storage::disk('dropbox')->getDriver();
                $stream = $fs->readStream($file);

                return \Response::stream(function () use ($stream) {
                    fpassthru($stream);
                }, 200, [
                    "Content-Type" => $fs->getMimetype($file),
                    "Content-Length" => $fs->getSize($file),
                    "Content-disposition" => "attachment; filename=\"" . basename($file) . "\"",
                ]);
            } else {
                $data = [
                    'message' => __('response.bad_request_long')
                ];
                return bodyResponseRequest(EnumResponse::NOT_FOUND, $data);
            }   
        } catch (Exception $e) {
            return $e;   
        }
    }

    public function destroy(Request $request, $file_name)
    {
        try {
            $selectDisk = $request["select_disk"];
            $dir = $selectDisk == 'dropbox' ? 'dropbox' : config('backup.destination.disks');
            $disk = Storage::disk($dir);
            $file = $selectDisk == 'dropbox' ? 'Laravel/'. $file_name : config('backup.destination.disks') .'/Laravel/'. $file_name;
            if ($disk->exists($file)) {
                $disk->delete($file);
                $data = [
                    'message' => __('response.successfully_deleted')
                ];
                return bodyResponseRequest(EnumResponse::SUCCESS, $data);
            } else {
                $data = [
                    'message' => __('response.bad_request_long')
                ];
                return bodyResponseRequest(EnumResponse::NOT_FOUND, $data);
            }
        } catch (Exception $e) {
            return $e;
        }
    }

     public function destroyDropbox($file_name)
    {
        try {
            $disk = Storage::disk('dropbox');
            $dir = 'Laravel/' . $file_name;
            if ($disk->exists($dir)) {
                $disk->delete($dir);
                $data = [
                    'message' => __('response.successfully_deleted')
                ];
                return bodyResponseRequest(EnumResponse::SUCCESS, $data);
            } else {
                $data = [
                    'message' => __('response.bad_request_long')
                ];
                return bodyResponseRequest(EnumResponse::NOT_FOUND, $data);
            }
        } catch (Exception $e) {
            return $e;
        }
    }
}
