<?php
session_start();
$_SESSION['PrevUrl'] = 'login_success.php';
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>display</title>
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/4.1.5/firebase.js"></script>
<script>
  // Initialize Firebase
  var config = {
    apiKey: "AIzaSyBhpHK-ve2s0ynnr8og8Zx0S69ttEFpDKk",
    authDomain: "project100-fe20e.firebaseapp.com",
    databaseURL: "https://project100-fe20e.firebaseio.com",
    projectId: "project100-fe20e",
    storageBucket: "project100-fe20e.appspot.com",
    messagingSenderId: "674827815611"
  };
  firebase.initializeApp(config);
  var redirectUrl = '<?php echo $_SESSION['PrevUrl']; ?>';
</script>
<script>

	function fnGetRequest(url, callback, callbackfailure) {
		//console.log('url is ', url);
		
		fetch(url, {
			method: 'GET'	  
		}).then((response) => {
			return response.json();	
		}).then((j) => {
			console.log('j is ', j);
			callback(j);
		}).catch((err) => {
			callbackfailure(err);
		});
	}
	
	function fnPostRequest(url, postData, callback, callbackfailure) {
		//console.log('url is ', url);
		//console.log('postData is ', postData);
		fetch(url, {
			method: 'POST',
			body: postData,
			mode: 'cors',
			redirect: 'follow',
			header: new Headers({
				'Content-Type': 'application/x-www-form-urlencoded'
			})
		}).then((response) => {
			return response.json();	
		}).then((j) => {
			console.log('j is ', j);
			callback(j);
		}).catch((err) => {
			callbackfailure(err);
		});
	}

	function fnPostJsonRequest(url, obj, callback, callbackfailure) {
		//console.log('url is ', url);
		//console.log('postDataobj is ', obj);

		fetch(url, {
			method: 'POST',	
			body: JSON.stringify(obj),
			mode: 'cors',
			redirect: 'follow'
		}).then((response) => {
			return response.json();	
		}).then((j) => {
			console.log('j is ', j);
			callback(j);
		}).catch((err) => {
			callbackfailure(err);
		});
	}
</script>
<script>
function postJson(url, params, callback, callbackFailed)
{
	var jqxhr = $.ajax({
		url:url,
  		type:'POST',
		data: JSON.stringify(params),
		contentType:"application/json; charset=utf-8"}
		)
	  .done(callback)
	  .fail(callbackFailed)
	  .always(function() {
		console.log( "finished" );
	  });
}

function post(url, params, callback, callbackFailed)
{
	var jqxhr = $.ajax({
		url:url,
  		type:'POST',
		data: params,
		})
	  .done(callback)
	  .fail(callbackFailed);
}
function get(url, callback, callbackFailed)
{
	var jqxhr = $.ajax({
		url:url,
  		type:'GET',
		})
	  .done(callback)
	  .fail(callbackFailed);
}

function cb(j, status, xhr) {
	if (j.error_message) {
		console.log('error : ', j); 
		return; 
	} 
	window.location.href = redirectUrl;
}


function cbFailed(jqxhr, settings, ex) {
	console.log('ex is ', ex);
	console.log('jqxhr is ', jqxhr);
	console.log('settings is ', settings);
}
</script>
<script>
	
	firebase.auth().onAuthStateChanged(function(user) {
	  if (user) {
		  console.log('auth user: ', user);
		var userData = {};
		userData.displayName = user.displayName;
		userData.email = user.email;
		userData.photoURL = user.photoURL;
		userData.profileUID = user.providerData[0].uid;
		userData.refreshToken = user.refreshToken;
		userData.uid = user.uid;
		
		console.log('userData on page load is ', userData);
	  } else {
		console.log('user is logged out');
	  }
	});
	
	function postToApi(obj) {
		//i want to send the obj i.e. userData to userApi.php
		
		//AJAX - we pass the data to backend without page refresh
		url = 'api.php';
		fnPostJsonRequest(url, obj, 
		function(j) { 
			console.log('success: ', j); 
			if (j.error_message) {
				console.log('error : ', j); 
				return; 
			} 
			
			//window.location.href = redirectUrl;
		}, 
		function (err) { 
			console.log('error on post is ', err); 
		});
	}


	function googleLogin() {
		var provider = new firebase.auth.GoogleAuthProvider();
		firebase.auth().signInWithPopup(provider).then(function(result) {
		
			var user = result.user;
		  	console.log('user is ', user);
			
			var userData = {};
			userData.displayName = user.displayName;
			userData.email = user.email;
			userData.photoURL = user.photoURL;
			userData.profileUID = user.providerData[0].uid;
			userData.refreshToken = user.refreshToken;
			userData.uid = user.uid;
			userData.provider_id = user.providerData[0].providerId;
			
			console.log('userData is ', userData);
			//something to pass userData to backend php api
			postJson('api.php', userData, cb, cbFailed);
		}).catch(function(error) {
		  console.log('error is ', error);
		});
	}
	
	function facebookLogin() {
		var provider = new firebase.auth.FacebookAuthProvider();
		firebase.auth().signInWithPopup(provider).then(function(result) {
		  
			var user = result.user;
		  	console.log('user is ', user);
			
			var userData = {};
			userData.displayName = user.displayName;
			userData.email = user.email;
			userData.photoURL = user.photoURL;
			userData.profileUID = user.providerData[0].uid;
			userData.refreshToken = user.refreshToken;
			userData.uid = user.uid;
			userData.provider_id = user.providerData[0].providerId;
			
			console.log('userData is ', userData);
			postJson('api.php', userData, cb, cbFailed);
		}).catch(function(error) {
		  console.log('error is ', error);
		});
	}
	
	//https://apps.twitter.com/
	function twitterLogin() {
		var provider = new firebase.auth.TwitterAuthProvider();
		firebase.auth().signInWithPopup(provider).then(function(result) {
		  var user = result.user;
		  	console.log('user is ', user);
			
			var userData = {};
			userData.displayName = user.displayName;
			userData.email = user.email;
			userData.photoURL = user.photoURL;
			userData.profileUID = user.providerData[0].uid;
			userData.refreshToken = user.refreshToken;
			userData.uid = user.uid;
			userData.provider_id = user.providerData[0].providerId;
			
			console.log('userData is ', userData);
			postJson('api.php', userData, cb, cbFailed);
		}).catch(function(error) {
		  console.log('error is ', error);
		});
	}
	
	//https://github.com/settings/developers
	function gitHubLogin() {
		var provider = new firebase.auth.GithubAuthProvider();
		
		firebase.auth().signInWithPopup(provider).then(function(result) {
 			var user = result.user;
		  	console.log('user is ', user);
			
			var userData = {};
			userData.displayName = user.displayName;
			userData.email = user.email;
			userData.photoURL = user.photoURL;
			userData.profileUID = user.providerData[0].uid;
			userData.refreshToken = user.refreshToken;
			userData.uid = user.uid;
			userData.provider_id = user.providerData[0].providerId;
			
			console.log('userData is ', userData);
			postJson('api.php', userData, cb, cbFailed);
		}).catch(function(error) {
		 	console.log('error is ', error);
		});
	}
	
	function signOut() {
		firebase.auth().signOut().then(function() {
		  // Sign-out successful.
			console.log('success logout');
			url = 'apiLogout.php';
			get(url, 
			function(j) { 
				console.log('success: ', j); 
				if (j.error_message) {
					console.log('error : ', j); 
					return; 
				}
				window.location.href = 'logout_success.php';
			}, 
			function (err) { 
				console.log('error on post is ', err); 
			});
		}).catch(function(error) {
		  // An error happened.
			console.log('error logout: ', error);
		});
	}
</script>

</head>

<body>
<p>Firebase Authentication </p>
<p><a href="" onClick="googleLogin(); return false;">Google</a></p>
<p><a href="" onClick="facebookLogin(); return false;">Facebook</a></p>
<p><a href="" onClick="twitterLogin(); return false;">Twitter</a></p>
<p><a href="" onClick="gitHubLogin(); return false;">Github</a></p>
<p><a href="" onClick="signOut(); return false;">Signout</a></p>
</body>
</html>