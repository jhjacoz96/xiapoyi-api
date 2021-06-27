<style>
    /** Define the margins of your page **/
        @page {
            margin: 80px 50px;
        }
  
        @font-face {
            font-family: 'Arial';
            src: url({{ storage_path('fonts/arial.ttf') }}) format("truetype");
            font-style: normal;
        }
  
        @font-face {
            font-family: 'Arial Bold';
            src: url({{ storage_path('fonts/arialbd.ttf') }}) format("truetype");
            font-style: normal;
        }
    
        body {
        font-family: 'Arial';
        font-style: normal;
        color: #5c5c5c;
        font-size: 12px;
      }
        table td, table td * {
      vertical-align: top;
  }
        #validate_table, tr, td, th, tbody, thead, tfoot {
          page-break-inside: avoid !important;
        }
  
        header {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            height: 50px;
        }
    
        footer {
            position: fixed;
            bottom: -50px;
            left: 0px;
            right: 0px;
            height: 50px;
        }
  
        .titulo {
          font-family: 'Arial Bold' !important;
          font-size: x-large;
          font-style: normal;
        }
  
  
  
        .subtitle {
          color: rgb(54, 127, 223);;
          font-size: 12px;
        }
  
        .section_title {
          color: rgb(54, 127, 223);;
          font-size: 13px;
        }
  
        .title_section {
          font-family: 'Arial Bold' !important;
          color: #5c5c5c;
          text-align:right;
          font-size: medium;
        }
        .root_cause{
           color: #5c5c5c;
           font-size: x-small;
        }
        .break_page{ page-break-after: always; }
        .break_page_avoid{ page-break-inside: avoid; }
  
    
        .line{
          position: absolute;
          top:50px;
          left: -60px;
          height: 8px;
        }
        .line_foot{
          -webkit-transform: scaleX(-1);
          transform: scaleX(-1);
          position: absolute;
          top:20px;
          left: -60px;
          height: 8px;
        }
        .img-logo {
       /* display: block; */
        max-width:110px;
        max-height:50px;
        width: auto;
        height: auto;
      }
         .title {
            text-align:center;
            font-family: 'Arial Bold' !important;
            font-size: medium;
        }
        .description-title {
          text-align:center;
          font-size: medium;
          color: rgb(54, 127, 223);;
        }
        hr {
         color: #cbcbcb;
        }
    
        
    
        table.outer-border-gray {
            border: 1px solid #d4d4d4;
    
        }
    
        table.outer-border-black {
            border: 1px solid #000;
    
        }
        .tab-font{
            font-family: 'Arial' !important;
        }
    
    
        table.tab-border {
            border-collapse: collapse;
            border-spacing: 0;
    
        }
    
        table.inner-border-gray > thead > tr > th,
        table.inner-border-gray > thead > tr > td,
        table.inner-border-gray > tbody > tr > th,
        table.inner-border-gray > tbody > tr > td,
        table.inner-border-gray > tfoot > tr > th,
        table.inner-border-gray > tfoot > tr > td {
            border-bottom: 1px solid #d4d4d4;
            border-right: 1px solid #d4d4d4;
        }
    
        table.inner-border-black > thead > tr > th,
        table.inner-border-black > thead > tr > td,
        table.inner-border-black > tbody > tr > th,
        table.inner-border-black > tbody > tr > td,
        table.inner-border-black > tfoot > tr > th,
        table.inner-border-black > tfoot > tr > td {
            border-bottom: 1px solid #000;
            border-right: 1px solid #000;
        }
    
        table.inner-border > thead > tr > :last-child,
        table.inner-border > tbody > tr > :last-child,
        table.inner-border > tfoot > tr > :last-child {
            border-right: 0;
        }
    
        table.inner-border > :last-child > tr:last-child > td,
        table.inner-border > :last-child > tr:last-child > th {
            border-bottom: 0;
        }
        table.inner-border > tbody > tr > td {
            padding-left: 5px;
        }
        .causas{
          padding: 5px 10px;
          background: white;
          width: 100%;
          line-height: 75%;
        }
        .nro-pa{
          color: rgb(54, 127, 223);;
          padding-left: 10px
        }
        input[type="text"], textarea{
          width: 100%;
          border: none;
        }
    
        label{
          color: rgb(54, 127, 223);;
          font-size: 12px;
        }
    
        .sub-title{
          padding-left: 35px;
          color: rgb(54, 127, 223);;
          font-size: 12px;
        }
        .icon-date{
          width: 18px;
          height: 18px;
          position: absolute;
          left: 500px;
    
        }
        #svg-icon-data{
          width: 18px;
          height: 18px;
          position: absolute;
          left: 505px;
    
        }
        #svg-icon-data > path {
            fill: #d4d4d4;
        }
    
    /* Metodo Ishikawa */
          .methodIshikawaTable,
          .methodFiveWhyTable {
            background: white;
            border-collapse: collapse;
          }
    
          .methodIshikawaTable td {
            width: 30px;
             height: 30px;
          }
     .methodIshikawaTable .segment {
            border-right: 2px solid gray;
          }
    
          .methodIshikawaTable .segment input{
            width: 10px;
    
          }
    
         .methodIshikawaTable .segment label {
            color: rgb(92, 92, 92);
            padding-left: 55px;
          }
       
        .methodIshikawaTable .segment .titleSegment {
           padding: 10px;
            margin-right: 10px;
            color: rgb(54, 127, 223);;
            background: rgb(235, 235, 235);
            margin-left: 45px;
          }
    
          .methodIshikawaTable .segment .titleSegment.top {
            margin-bottom: 10px;
            margin-top: 10px;
          }
          .methodIshikawaTable .segment .titleSegment.bottom {
            margin-top: 10px;
            margin-bottom: 10px;
          }
    
          .methodIshikawaTable .middleIshikawa {
            background: red;
            height: 5px;
            width: 100%;
          }
    
          .infoConformityContainer {
            position: relative;
          /*  width: 00px;*/
          }
    
          .infoConformity {
            position: static;
            background: rgb(54, 127, 223);;
            width: 100px;
            max-width: 100px;
            max-height: 100px;
            padding: 5px 5px;
            border-radius: 5px;
            color: white;
            margin-left:2px;
            text-align: center;
            top: 100px;
            left: 610px;
            word-wrap: break-word;
            overflow-wrap: break-word;
          }
    
          .cell_why{
            background-color: #ebebeb;
            padding: 5px;
            color:  #5c5c5c;
          }
          .root_cause{
             color: #5c5c5c;
             font-size: x-small;
          }
        
   
          .tbl{
            background: #fff;
            border: 0px;
            border-spacing: 5px;
          }
          .tblcause{
            border: 0px;
            border-spacing: 0px;
            color: #5c5c5c;
    
          }
          #tbl5why td input[type='radio'] {
            margin-left: 20px;
            color: rgb(54, 127, 223);;
          }
    
          table.tblluvia {
            border-collapse: collapse;
            background-color: #ebebeb;
            padding: 2px; 
          }
          
          #tblluvia tr:first-child td {
            text-align:center;
            /* color: rgb(54, 127, 223);; */
            font-weight: 400;
          }
          #tblluvia tr td {
            text-align:center;
            font-weight: 400;
            color:  #5c5c5c;
          }
          #tblluvia tr td input[type='radio'] {
            margin-left: 40px;
          }
  
  
          #tblpareto tr:first-child td {
             color: rgb(54, 127, 223);;
             font-weight: 400;
             background: none;
          }
  
          #tblpareto td input[type='radio'] {
            color: rgb(54, 127, 223);;
            margin-left: 20%;
          }
  
          #tblpareto {
            border-collapse: collapse;
          }
  
          /* #tblpareto tbody {
            background-color: #ebebeb;
            color: rgb(54, 127, 223);;
            font-weight: 400;
            color:  #5c5c5c;
          }
  
          #tblpareto thead {
             color: rgb(54, 127, 223);;
             font-weight: 400;
             background: none;
  
          } */
  
          #tblpareto td {
            background-color: #ebebeb;
            padding: 5px;
            color:  #5c5c5c;
          }
  
          .linered {
            background: #ff3939;
            height: 7px;
            width: 100%;
          }
          .lineyellow{
            background: #FCFF1D;
            height: 7px;
            width: 100%;
          }
          .linegreen{
            background: #00ce52;
            height: 7px;
            width: 100%;
          }
          .collapse{
            padding: 0px;
    
          }
          .tblseg{
            background: #fff;
            border-spacing: 0px;
            border: 2px #000;
          }
          .nc_box{
           padding: 10px;
            background-color: #ebebeb;
           /* width: 30px;
            height: 30px;*/
  
          }
  
          #tblAcciones tr:first-child td {
             color: rgb(54, 127, 223);;
             font-weight: 400;
             background: none;
          }
  
          #tblAcciones td input[type='radio'] {
            color: rgb(54, 127, 223);;
            margin-left: 20%;
          }
  
          #tblAcciones {
            border-collapse: collapse;
          }
  
          #tblAcciones td {
            background-color: #ebebeb;
            padding: 5px;
            color:  #5c5c5c;
          }
  
          .badgeNoTratado {
              width: 6px; 
              height: 6px; 
              background: #FFFFFF;
              position: relative;
              top: 14px;
          }
          .badgeNotificado {
              width: 6px; 
              height: 6px; 
              background: #FFFF00;
              position: relative;
              top: 14px;
          }
          .badgePlanificado {
              width: 6px; 
              height: 6px; 
              background: #FFC000;
              position: relative;
              top: 14px;
          }
          .badgeEjecucion {
              width: 6px; 
              height: 6px; 
              background: #00FF00;
              position: relative;
              top: 14px;
          }
          .badgeEjecutado {
              width: 6px; 
              height: 6px; 
              background: #099524;
              position: relative;
              top: 14px;
          }
          .badgeValidado {
              width: 6px; 
              height: 6px; 
              background: #0000FF;
              position: relative;
              top: 14px;
          }
  
          .badgeActivo {
              width: 6px; 
              height: 6px; 
              background: #00FF00;
              position: relative;
              top: 14px;
          }
          .badgeHistorico {
              width: 6px; 
              height: 6px; 
              background: red;
              position: relative;
              top: 14px;
          }
  
          #tblrecurso {
            font-weight: 400;
            color:  #5c5c5c;
            align-content: initial;
          }
  
          table#tblrecurso {
            padding-left: 8px;
            padding-right: 8px;
          }
  
          table#tblrecurso  td {
            padding: 3px;
          }
  
        /*  .nc_box p {
              overflow:hidden;
        white-space:nowrap;
        text-overflow: ellipsis;
             /* word-break: break-all;*/
           /* }*/
          .tblseg tr:first-child td {
             color: rgb(54, 127, 223);;
             font-size: x-small;
          }
          .box-input-memo{
            font-size: 12px;
            background-color: white;
            padding: 2px 5px 2px 5px;
            margin-top: 3px;
            width: 100%;
            min-height: 50px;
            text-align: justify;
        }
        .greenth {
    background: rgb(24, 238, 24);
  }
  
  .yellowth {
    background: rgb(228, 228, 10);
  }
  
  .orangeth {
    background: orange;
  }
  
  .redth {
    background: red;
  }
  
  .resumen-cel {
    width: 18%;
  }
  
  .table {
    background: #e8ecef;
  }
  
  table-bordered {
    border: rgb(172, 166, 166) 1px solid !important;
  }
  
  .no-border {
    border: none !important;
    background: none !important;
    background: white !important;
  }
    </style>
    