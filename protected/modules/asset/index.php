<html>
	<head>
		<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
		<script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
		<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
		<object
			id="activex"
			classid="clsid:533A04D8-02EA-4C59-8E98-49A2D6A41DDD"
			style="LEFT: 0px; WIDTH: 100%; TOP: 0px; HEIGHT: 0px">
		</object>
		<object
			id="ssuapi"
			classid="clsid:3D1A905A-8EA1-408E-B5BD-AEC937DE6136"
			codeBase="ssuapi.cab"
			style="LEFT: 0px; WIDTH: 100%; TOP: 0px; HEIGHT: 0px">
		</object>
		<script type="text/javascript">
		function connect()
		{
			try
			{
				var result = ssuapi.SSUConnect("");

				if (result == false)
					$("h4#tagID").text("connect faield");
				else
					$("h4#tagID").text("connect succeed");
			}
			catch (e)
			{
				alert(e);
			}
		}

		function disconnect()
		{
			try
			{
				var result = ssuapi.SSUDisconnect();

				if (result == false)
					$("h4#tagID").text("disconnect faield");
				else
					$("h4#tagID").text("disconnect succeed");
			}
			catch (e)
			{
				alert(e);
			}
		}

		function query()
		{
			try
			{
				var tagID = ssuapi.SSUTagQuery();
				$("h4#tagID").text("tag ID:  " + tagID);
			}
			catch (e)
			{
				alert(e);
			}
		}

		function tag_read()
		{
			try
			{
				var tagContent = ssuapi.SSUTagReadUSR();
				$("h4#tagContent").text("tag content:  " + tagContent);
			}
			catch (e)
			{
				alert(e);
			}
		}

		function tag_write()
		{
			try
			{
				var content = $("input#content").val();
				var result = ssuapi.SSUTagWriteUSR(content);

				if (result == false)
					$("h4#tagContent").text("write faield");
				else
					$("h4#tagContent").text("write succeed");
			}
			catch (e)
			{
				alert(e);
			}
		}
		function tag_read_new()
		{
			try
			{
				var result = ssuapi.SSUConnect("");
				var tagContent = ssuapi.SSUTagReadUSR();
				$("h4#tagContent").text("tag content:  " + tagContent);
			}
			catch (e)
			{
				alert(e);
			}
		}


		</script>
	</head>
	<body>
		<div class="container">
			<h1>DLL simple test</h1>
			<div class="row">
				<div class="col-md-8">
					<input class="form-control" id="name" placeholder="type your name here">
				</div>
				<div class="col-md-4">
					<button class="form-control" onclick="hello()">Say Hello</button>
				</div>
			</div>
			<br>
			<h1>SSU_API test</h1>
			<br>
			<div class="row">
				<div class="col-md-2">
					<button class="btn btn-success btn-block" onclick="connect()">Connect</button>
				</div>
				<div class="col-md-2">
					<button class="btn btn-danger btn-block" onclick="disconnect()">Disconnect</button>
				</div>
				<div class="col-md-2">
					<button class="btn btn-info btn-block" onclick="query()">Get Tag ID</button>
				</div>
				<div class="col-md-2">
					<button class="btn btn-info btn-block" onclick="tag_read_new()">Read</button>
				</div>
				<div class="col-md-2">
					<input class="form-control" id="content" type="text" placeholder="write to tag">
				</div>
				<div class="col-md-2">
					<button class="btn btn-info btn-block" onclick="tag_write()">Write</button>
				</div>
			</div>
			<br>
			<h4 id="tagID"></h4>
			<br>
			<h4 id="tagContent"></h4>
		</div>
	</body>
</html>