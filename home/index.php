<!-- IE in quirks mode -->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN">
<html>
	<title>A&F - new search </title>
	<head>
	<title>Debates</title>
		<link rel="stylesheet" href="../common/css/slick.grid.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="../common/css/smoothness/jquery-ui-1.8.5.custom.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="./examples.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="css/global.css" type="text/css" media="all" />
		<link rel="stylesheet" href="css/ui-lightness/jquery-ui.css" type="text/css" media="all" />
		
		
		<style>
			#messagewindowDiv { width: 780px; height: 100%;}
		</style>

		<script src="../common/lib/firebugx.js"></script>
		<script src="../common/lib/jquery-1.4.3.min.js"></script>
		<script src="../common/lib/jquery-ui-1.8.5.custom.min.js"></script>
		<script src="../common/lib/jquery.event.drag-2.0.min.js"></script>
        <script src="../common/js/slick.core.js"></script>
		<script src="../common/plugins/slick.cellrangedecorator.js"></script>
		<script src="../common/plugins/slick.cellrangeselector.js"></script>
		<script src="../common/plugins/slick.cellselectionmodel.js"></script>
		<script language="JavaScript" src="../common/js/slick.editors.js"></script>
		<script language="JavaScript" src="../common/js/slick.grid.js"></script>
		
		<script language="javascript" type="text/javascript" src="./js/maxrating.js"></script>
   		<script language="JavaScript" src="../common/js/jquery.json-2.2.js"></script>
		<script type="text/javascript" src="./js/home.js"></script>
		<script src="http://connect.facebook.net/en_US/all.js"></script>

		<script>
			$(document).ready(function(){
				
				/*$('#header').drag(
					function(){
						var divHeight = $(this).height() + 100;
						if(divHeight < 400){
							$(this).css('height', divHeight);
							var divTop = $('#content')[0].offsetTop + 100;
							$('#content').css('top', divTop);
						}	
					}
				);
				$('#footer').drag(
					function(){
						var divHeight = $('#header').height() - 100;
						if(divHeight > 0){
							$('#header').css('height', divHeight);
							var offsetTop = $(this).offsetTop - 100;
							$(this).css('top', offsetTop);
							offsetTop = $('#content')[0].offsetTop - 100;
							$('#content').css('top', offsetTop);
						}	
					}
				);*/
			
			});
		</script>
	</head>
	
	<body>	
		<img class="logoImg" id="logo" src="./images/logo.jpg"></img>
		<div id="header-main">
			<div id="login">
				<a href="javascript:void();" id="login">Login</a>
				<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#appId=275057425854799&amp;xfbml=1"></script><fb:name  />
				<script src="http://connect.facebook.net/en_US/all.js"></script>
				<script>
				  // initialize the library with the API key
				  FB.init({ apiKey: '275057425854799' });

				  // fetch the status on load
				  FB.getLoginStatus(handleSessionResponse);

				  $('#login').bind('click', function() {
					FB.login(handleSessionResponse);
				  });

				  $('#logout').bind('click', function() {
					FB.logout(handleSessionResponse);
				  });

				  $('#disconnect').bind('click', function() {
					FB.api({ method: 'Auth.revokeAuthorization' }, function(response) {
					  clearDisplay();
					});
				  });

				  // no user, clear display
				  function clearDisplay() {
					$('#user-info').hide('fast');
				  }

				  // handle a session response from any of the auth related calls
				  function handleSessionResponse(response) {
					// if we dont have a session, just hide the user info
					if (!response.session) {
					  clearDisplay();
					  return;
					}

					// if we have a session, query for the user's profile picture and name
					FB.api(
					  {
						method: 'fql.query',
						query: 'SELECT name, pic FROM profile WHERE id=' + FB.getSession().uid
					  },
					  function(response) {
						var user = response[0];
						$('#user-info').html('<img src="' + user.pic + '">' + user.name).show('fast');
					  }
					);
				  }
				</script>
			</div>
			<div id="main-nav-links">
				<div id="addResearch">
					<input type="textbox" id="searchAdd" value=""/>
					<a href ="javascript:void(0)" class="search-go">CONTINUE</a>
					<a href ="javascript:void(0)" class="topic-main">MY ACCOUNT</a>
					<a href ="javascript:void(0)" class="topic-main">LATEST</a>
					<a href ="javascript:void(0)" class="topic-main">POPULAR</a>
					<a href ="javascript:void(0)" class="topic-main">BROWSE</a>
				</div>		
			</div>	

		</div>
		<div id="breadcrumb"><span class="breadcrumb-links selected">Summary</span><span class="breadcrumb-links">Debate</span><span class="breadcrumb-links">Compare</span></div>
		<div id="header">
			<!--Put Header Context in here.  -->
			<span id="topicSpan"></span>
			<span id='addArguments' class="action_topc_nav">add</span>
			<div id="tools_div">
			   <p class="ratingbox" align="center"></p>
			</div>	
		</div>
	
		<div id="left-nav">
			<div id="left-sidebar">
				<div id="debateRef">
					<div class="wrapper">
						<input type="textbox" id="search" value=""/>
						<span class="action_side_search" id="searchBtn">Go!</span>
					</div>
					<a href ="javascript:void(0)" class="topic">Arguments & Facts<span id='addNewArguments' class="action_side_nav">add</span></a>
					<div id="statmentsDiv"></div>
					<a href ="javascript:void(0)" class="topic">Questions & Answers<span id='addNewQuestions' class="action_side_nav">add</span></a>
					<div id="questionsDiv"></div>
				</div>	
			</div>
			<div id="left-sidebar-search">
				<div id="debateRef">
					<a href ="javascript:void(0)" class="topic">My Research</a>
					<div id="searchDiv" ></div>	
				</div>	
			</div>	
		</div>
	
		<div id="mainContext">
			<div id="debateDiv">
				<div class="classArguments classAnswers">

					<div style="position:relative">
						<div style="width:600px;">
							<div id="messagewindowDiv">
								<span class="loading">Loading...</span>
							</div>
						</div>
					</div>
				
					<form id="save" action="?" method="POST">
						<input type="submit" value="Save">
						<input type="hidden" name="data" value="">
					</form>

					<!-- New Dialog Form to add new A/F/Q/A/D -->
					<form id="chatForm" action="<?php echo $PHP_SELF;?>" method="post">
						<label>Name: </label><input type="text" id="author" />
						<label>Summary:</label><input type="text" id="msg" />
						<label>Description:</label><textarea rows="2" cols="20" id="description"></textarea>
						<a href='javascript:void(0)' class="btn_ref" id="submitID">Ok<a/>
						<a href='javascript:void(0)' class="btn_ref" id='cancelRef'>Cancel</a>
						<input id="statments" value="Y" />
					</form>
				</div>	
			</div>
			
		</div>
		
	</body>	
</html>	