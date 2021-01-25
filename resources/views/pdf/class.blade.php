
<!DOCTYPE html>
<html lang="en">
@if(session()->get('section') == "primary")
	<head>
		<style type="text/css">
			.top {
				border:2px solid #6279E5;
				width:90%;
				border-bottom:none;
				margin: 0px auto;
				padding: 10px;

			}
			hr {
				width:200px;
				color:#6279E5;
			}
			.noborder td strong
			{
				color:#6279E5;
				font-family:Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
				font-size:14px;
				font-weight:bold;
			}
			.page {
				width: 100%;
				margin: 0px auto;
			}
			.table {
				margin: 0px auto;
				width: 90%;
				border: 2px solid #6279E5;

			}
			.table tr, .table th, .table td {
				border: 1px solid #6279E5;
				padding:10px;
			}

			.log {
				float:left;
				width: 120px;
				height:130px;
			}
			.dtl {
				text-align:center;}
			h1, h2, h3, h4, h5 {
				text-align:center;}
			h1 {
				font-family: "DejaVu Sans Condensed", Helvetica, Arial, sans-serif;
				color:#6279E5;
				font-size:44px;
				margin:0px;
				font-stretch:condensed;
			}
			h2 {
				font-family: "DejaVu Sans Condensed", Helvetica, Arial, sans-serif;
				color:#D14B4D;
				font-size:22px;
				margin:0px;
			}
			h3 {
				font-family:"Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed",
				Helvetica, Arial, sans-serif;
				color:#6279E5;
				margin:0px;
			}
			h5 {
				margin:0px;
				font-family:"Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed",
				Helvetica, Arial, sans-serif;
				color:#D14B4D;
			}
			p {
				margin:0px;
				font-family:"Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed",
				Helvetica, Arial, sans-serif;
				color:#6279E5;
				text-align:center;
				font-size:14px;
			}
			.pp {
				width:200px;

			}
			.pp p {
				text-align:left;
			}
			a {
				color: #000000;
				text-decoration: none;
			}
			.underline {
				border-bottom: 1px solid #6279E5;
				text-align: center;
				font-family: "DejaVu Sans Mono", monospace;
				font-size: 16px;
			}

			.log {
				float:left;
				width: 120px;
				height:130px;
			}
			.bxx {
				width:900px;
				margin:0px auto;
			}
			.dtl {
				text-align:center;}

			th.rotate {
				/* Something you can count on */
				width:120px;
				color:#D14B4D;

			}

			th.rotate > div {

			}
			.subject {
				color:#6279E5;
			}
			.remark {
				width:70px;
			}

			.noborder {
				width: 100%;
				margin: 0px auto;
				border:0px solid white;
				border-spacing: 20px;
			}
			.noborder p {
				text-align:left;}
			.base {
				margin:0px auto;
				border:2px solid #6279E5;
				padding:10px;
				width:1240px;
				font-size:14px;
				margin-top:40px;
			}
		</style>
	</head>
@elseif(session()->get('section') == "secondary")
		<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="{{url('/css/custom.css')}}" rel="stylesheet" />
    <link href="{{url('/css/table.css')}}" rel="stylesheet" />
<style type="text/css">
hr {
		width:200px;
		color:#6279E5;

		}
	.noborder td strong
		   {
			color:#6279E5;
			font-family:Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
			font-size:16px;
			font-weight:normal;
			}
        .page {
            width: 100%;
            margin: 0px auto;
        }
        .table {
            margin: 0px auto;
            width: 100%;
            border: 1px solid #6279E5;
			font-size:14px;
        }
        .table tr, .table th, .table td {
            border: 1px solid #6279E5;
        }

		.log {
			float:left;
			width: 140px;
			height:150px;
			}
		.dtl {
			text-align:center;}
		h1, h2, h3, h4, h5 {
			text-align:center;}
		h1 {
			font-family: "DejaVu Sans Condensed", Helvetica, Arial, sans-serif;
			color:#6279E5;
			font-size:36px;
			margin:0px;
			font-stretch:expanded;
			}
		h2 {
			font-family: "DejaVu Sans Condensed", Helvetica, Arial, sans-serif;
			color:#D14B4D;
			font-size:20px;
			margin:0px;
			}
		h3 {
			font-family:"Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed",
			 Helvetica, Arial, sans-serif;
			color:#6279E5;
			margin:0px;
			}
		h5 {
			margin:0px;
			font-family:"Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed",
			 Helvetica, Arial, sans-serif;
			color:#D14B4D;
			}
		p {
			margin:0px;
			font-family:"Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed",
			 Helvetica, Arial, sans-serif;
			 color:#6279E5;
			 text-align:center;
			 font-size:14px;
				}
		.pp {
			width:200px;

			}
		.pp p {
			text-align:left;
			}
        a {
            color: #000000;
            text-decoration: none;
        }
		.underline {
            border-bottom: 1px solid #6279E5;
            text-align: center;
            font-family: "DejaVu Sans Mono", monospace;
            font-size: 15px;
        }
        .noborder {
            width: 100%;
            margin: 0px auto;
            border:0px solid white;
            border-spacing: 20px;
        }

</style>
<style type="text/css">


		.bxx {
		width:880px;
		}

        th.rotate {
            /* Something you can count on */
            height: 98px;
            width:30px;
            white-space: nowrap;
			color:#D14B4D;
        }

        th.rotate > div {
            float:left;
            position: relative;
            width: 20px;
            top: 55px;
            border-style: none;
            font-size: 10px;
            -ms-transform:rotate(270deg); /* IE 9 */
            -moz-transform:rotate(270deg); /* Firefox */
            -webkit-transform:rotate(270deg); /* Safari and Chrome */
            -o-transform:rotate(270deg); /* Opera */
        }
        .subject {
            color:#6279E5;
			margin-top:40px
        }
        .remark {
            width:100px;
        }
		.table {
			width:928px;
			float:left;
			margin:0px;
			padding:0px;
			}
		.small {
			width:310px;
			border-left:none;
			font-size:14px;
			}
		.base {
			clear:both;
			border:2px solid #6279E5;
			padding:10px;
			margin-top:40px;
			width:1240px;
			}
     .box {
		 width:1240px;
		 margin:0px auto;
		 }
	.top {
		border:1px solid #6279E5;
		width:100%;
		border-bottom:none;

		}
	.wrap {
		clear:both;
		border: 2px solid #6279E5;
		width:100%;

		}

    </style>
</head>
		@endif
<body>

@include('pdf.header')
<table class="noborder">
    <tr>
        <td width="800px"> </td>
        <td class="underline" >{{$session."/".($session+1)}}</td>
    	<td width="45px"><strong>SESSION</strong></td>
    </tr>
</table>
<table class="noborder">
    <tr>
        <td width="180px"><strong>NAME OF STUDENT:</strong></td><td colspan="4" class="underline">
            {{$student->name}}</td>
    </tr>
  </table>
  <table class="noborder"> 
    <tr>
    	<td width="45px"><strong>CLASS:</strong></td>
        <td class="underline" >{{$student->getClassName($level)}}</td>
    	<td width="85px"><strong>ADM. NO.</strong></td>
        <td class="underline">{{$student->student_id}}</td>
     
    </tr>
    </table>
<br>
@foreach($levels as $k => $level)
    @include('pdf.showall')
@endforeach
</body>

</html>