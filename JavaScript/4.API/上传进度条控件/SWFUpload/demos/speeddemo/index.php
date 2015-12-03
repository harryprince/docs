<!DOCTYPE html>
<html>
<head>
	<title>SWFUpload Demos - Speed Demo</title>
	<link href="../css/default.css" rel="stylesheet" type="text/css" />
	<style type="text/css">
		table table td {
			width: 250px;
			white-space: nowrap;
			padding-right: 5px;
		}
		table table tr:nth-child(2n+1) {
			background-color: #EEEEEE;
		}
		table table td:first-child {
			font-weight: bold;
		}

		table table td:nth-child(2) {
			text-align: right;
			font-family: monospaced;
		}

	</style>
	<script type="text/javascript" src="../swfupload/swfupload.js"></script>
	<script type="text/javascript" src="../swfupload/swfupload.queue.js"></script>
	<script type="text/javascript" src="../swfupload/swfupload.speed.js"></script>
	<script type="text/javascript" src="js/handlers.js"></script>
	<script type="text/javascript">
		var swfu;
//技术文档：http://www.cnblogs.com/freespider/archive/2010/06/23/1763656.html
		window.onload = function() {
			var settings = {
				flash_url : "../swfupload/swfupload.swf",		//flash_url 
				flash9_url : "../swfupload/swfupload_fp9.swf",
				upload_url: "upload.php",		//上传处理Php文件
				file_size_limit : "100 MB",		//上传大小，单位MB
				file_types : "*.*",					//允许上传的文件类型
				file_types_description : "All Files",		//文件类型描述
				file_upload_limit : 100,			//限定用户一次性最多上传多少个文件，在上传过程中，该数字会累加，如果设置为“0”，则表示没有限制
				file_queue_limit : 0,	//上传队列数量限制，该项通常不需设置，会根据file_upload_limit自动赋值

				debug: false,	//是否显示调试信息

				// Button settings
				button_image_url: "images/XPButtonUploadText_61x22.png",
				button_width: "61",
				button_height: "22",
				button_placeholder_id: "spanButtonPlaceHolder",
				
				moving_average_history_size: 40,
				
				// The event handler functions are defined in handlers.js
				swfupload_preload_handler : preLoad,	//当Flash控件成功加载后触发的事件处理函数
				swfupload_load_failed_handler : loadFailed,
				file_queued_handler : fileQueued,
				file_dialog_complete_handler: fileDialogComplete,
				upload_start_handler : uploadStart,		//开始上传文件前触发的事件处理函数
				upload_progress_handler : uploadProgress,
				upload_success_handler : uploadSuccess,		//文件上传成功后触发的事件处理函数
				upload_complete_handler : uploadComplete,
				
				custom_settings : {
					tdFilesQueued : document.getElementById("tdFilesQueued"),
					tdFilesUploaded : document.getElementById("tdFilesUploaded"),
					tdErrors : document.getElementById("tdErrors"),
					tdCurrentSpeed : document.getElementById("tdCurrentSpeed"),
					tdAverageSpeed : document.getElementById("tdAverageSpeed"),
					tdMovingAverageSpeed : document.getElementById("tdMovingAverageSpeed"),
					tdTimeRemaining : document.getElementById("tdTimeRemaining"),
					tdTimeElapsed : document.getElementById("tdTimeElapsed"),
					tdPercentUploaded : document.getElementById("tdPercentUploaded"),
					tdSizeUploaded : document.getElementById("tdSizeUploaded"),
					tdProgressEventCount : document.getElementById("tdProgressEventCount")
				}
			};

			swfu = new SWFUpload(settings);
	     };
	</script>
</head>
<body>
<div id="header">
	<h1 id="logo"><a href="../">SWFUpload</a></h1>
	<div id="version">v2.5.0</div>
</div>

<div id="content">
	<h2>Speed Demo</h2>
	<form id="form1" action="index.php" method="post" enctype="multipart/form-data">
		<p>This page demonstrates the use of the SWFUpload.speed plugin</p>

		<div style="width: 61px; height: 22px; margin-bottom: 10px;">
			<span id="spanButtonPlaceHolder"></span>
		</div>

		<table cellspacing="0">
			<tr>
				<td>
					<table cellspacing="0">
						<tr>
							<td>Files Queued:</td>
							<td id="tdFilesQueued"></td>
						</tr>			
						<tr>
							<td>Files Uploaded:</td>
							<td id="tdFilesUploaded"></td>
						</tr>			
						<tr>
							<td>Errors:</td>
							<td id="tdErrors"></td>
						</tr>		
					</table>
				</td>
				<td>
					<table cellspacing="0">
						<tr>
							<td>Current Speed:</td>
							<td id="tdCurrentSpeed"></td>
						</tr>			
						<tr>
							<td>Average Speed:</td>
							<td id="tdAverageSpeed"></td>
						</tr>			
						<tr>
							<td>Moving Average Speed:</td>
							<td id="tdMovingAverageSpeed"></td>
						</tr>			
						<tr>
							<td>Time Remaining</td>
							<td id="tdTimeRemaining"></td>
						</tr>			
						<tr>
							<td>Time Elapsed</td>
							<td id="tdTimeElapsed"></td>
						</tr>			
						<tr>
							<td>Percent Uploaded</td>
							<td id="tdPercentUploaded"></td>
						</tr>			
						<tr>
							<td>Size Uploaded</td>
							<td id="tdSizeUploaded"></td>
						</tr>			
						<tr>
							<td>Progress Event Count</td>
							<td id="tdProgressEventCount"></td>
						</tr>			
					</table>
				</td>
			</tr>
		</table>
	</form>
</div>
</body>
</html>
