$j=jQuery;var IWD=IWD||{};IWD.Signin={config:null,showDialog:!1,googleHandleRequest:null,googleData:null,yahooDialog:null,twitterDialog:null,init:function(){"undefined"!=typeof SigninConfig&&(IWD.Signin.config=SigninConfig,("undefined"==typeof IWD.Signin.config.isLoggedIn||1!=IWD.Signin.config.isLoggedIn)&&(this.initOpenDialog(),this.initLoginLink(),this.initLoginForm(),this.initRegisterLink(),this.initRegisterForm(),this.initForgotPassword(),this.initForgotForm(),this.initPaypalLogin(),this.initYahooLogin(),this.initTwitterLogin()))},initPaypalLogin:function(){$(document).on("click",".btn-paypal-login",function(n){n.preventDefault();var i=$j(".btn-paypal-login").attr("href");mywindow=window.open(i,"_PPIdentityWindow_","location=1, status=0, scrollbars=0, width=400, height=550")})},initOpenDialog:function(){$j(".links a").each(function(){var n=$j(this).attr("href"),i=/wishlist/gi,o=n.match(i);o&&$j(this).click(function(n){n.preventDefault(),IWD.Signin.saveLink(),$j("#signin-modal").addClass("md-show"),IWD.Signin.prepareLoginForm()})}),$j("#signin-modal .close").click(function(){$j("#signin-modal").removeClass("md-show")}),$j("a.link-wishlist").attr("onclick",""),$j("a.link-wishlist").click(function(n){n.preventDefault(),IWD.Signin.saveLink(),$j("#signin-modal").addClass("md-show"),IWD.Signin.prepareLoginForm()}),$j(".email-friend a, .emailto-link a").click(function(n){n.preventDefault(),IWD.Signin.saveLink(),$j("#signin-modal").addClass("md-show"),IWD.Signin.prepareLoginForm()})},saveLink:function(){var n={};n.url=document.location.href,$j.post(IWD.Signin.config.url+"signin/json/redirect",n,IWD.Signin.parseLoginResponse,"json")},initLoginLink:function(){$j(".signin-modal").click(function(n){n.preventDefault(),IWD.Signin.saveLink(),$j("#signin-modal").addClass("md-show"),IWD.Signin.prepareLoginForm()})},initLoginForm:function(){$j(document).on("click","#signin-login",function(n){n.preventDefault(),$j("#login-form").submit()}),$j(document).on("submit","#login-form",function(n){IWD.Signin.showLoader(),n.preventDefault();var i=$j("#login-form").serializeArray();$j.post(IWD.Signin.config.url+"signin/json/login",i,IWD.Signin.parseLoginResponse,"json")})},prepareLoginForm:function(){IWD.Signin.showLoader(),$j.post(IWD.Signin.config.url+"signin/json/load",{block:"login"},IWD.Signin.parseResponseLoad,"json")},parseResponseLoad:function(n){if(IWD.Signin.hideLoader(),!0){var i=n.id;$j("#signin-ajax-load").html(n[i])}},initRegisterLink:function(){$j(document).on("click","#create-account-singup",function(n){n.preventDefault(),$j(".login-form").hide(),IWD.Signin.insertLoader(),IWD.Signin.prepareRegisterForm()}),$j(document).on("click",".account-create-signin .back-link, .account-forgotpassword .back-link",function(n){n.preventDefault(),$j("html, body").animate({scrollTop:0},"slow"),IWD.Signin.insertLoader(),IWD.Signin.prepareLoginForm()})},initRegisterForm:function(){$(document).on("submit",".account-create-signin #form-validate",function(n){n.preventDefault();var i=$j(".account-create-signin #form-validate").serializeArray();$j.post(IWD.Signin.config.url+"signin/json/register",i,IWD.Signin.parseRegisterResponse,"json")})},prepareRegisterForm:function(){$j.post(IWD.Signin.config.url+"signin/json/load",{block:"register"},IWD.Signin.parseResponseLoad,"json")},initForgotPassword:function(){$j(document).on("click","#forgot-password",function(n){n.preventDefault(),IWD.Signin.insertLoader(),$j.post(IWD.Signin.config.url+"signin/json/load",{block:"forgotpassword"},IWD.Signin.parseResponseLoad,"json")})},initForgotForm:function(){$(document).on("submit",".account-forgotpassword #form-validate",function(n){n.preventDefault();var i=$j(".account-forgotpassword #form-validate").serializeArray();$j.post(IWD.Signin.config.url+"signin/json/forgotpassword",i,IWD.Signin.parseForgotPasswordResponse,"json")})},insertLoader:function(){$j("#signin-ajax-load").empty(),IWD.Signin.showLoader()},showLoader:function(){$j(".ajax-loader").show()},hideLoader:function(){$j(".ajax-loader").hide()},parseLoginResponse:function(n){null!=n&&(IWD.Signin.hideLoader(),"undefined"!=typeof n.error&&1==n.error&&($j("#signin-error").remove(),$j("<div />").attr("id","signin-error").addClass("signin-error").html(n.message).insertAfter("#login-form")),"undefined"!=typeof n.linkAfterLogin&&("undefined"!=typeof n.message?setTimeout(function(){setLocation(n.linkAfterLogin)},2500):setTimeout(function(){setLocation(n.linkAfterLogin),location.reload()},500)))},showMessage:function(n){IWD.Signin.hideLoader(),$j("#signin-error").remove(),$j("<div />").attr("id","signin-error").addClass("signin-error").html(n).insertAfter("#login-form")},redirect:function(n){setLocation(n)},parseRegisterResponse:function(n){IWD.Signin.hideLoader(),$j("#signin-error").remove(),"undefined"!=typeof n.error&&1==n.error&&$j("<div />").attr("id","signin-error").addClass("signin-error").html(n.message).insertAfter(".account-create-signin #form-validate"),"undefined"!=typeof n.linkAfterLogin&&($j(".account-create-signin #form-validate").empty(),"undefined"!=typeof n.message?($j("<div />").attr("id","signin-error").addClass("signin-success").html(n.message).appendTo(".account-create-signin #form-validate"),setTimeout(function(){setLocation(n.linkAfterLogin)},2500)):setTimeout(function(){setLocation(n.linkAfterLogin)},500)),"undefined"!=typeof n.emailConfirmation&&"undefined"!=typeof n.message&&$j("<div />").attr("id","signin-error").addClass("signin-success").html(n.message).appendTo(".account-create-signin #form-validate")},parseForgotPasswordResponse:function(n){IWD.Signin.hideLoader(),"undefined"!=typeof n.error?$j("<div />").attr("id","signin-error").addClass("signin-error").html(n.message).appendTo(".account-forgotpassword #form-validate"):(IWD.Signin.insertLoader(),IWD.Signin.prepareLoginForm())},loginWithFacebook:function(){1!=IWD.Signin.config.isLoggedIn&&FB.getLoginStatus(function(n){"connected"===n.status?FB.api("/me",IWD.Signin.pushFacebookData):FB.login(function(n){n.authResponse&&FB.api("/me",IWD.Signin.pushFacebookData)},{scope:"email"})})},pushFacebookData:function(n){var i={};i.firstname=n.first_name,i.lastname=n.last_name,i.id=n.id,i.email=n.email,$j.post(IWD.Signin.config.url+"signin/json/facebook",i,IWD.Signin.parseLoginResponse,"json")},initYahooLogin:function(){$j(document).on("click",".btn-yahoo-login",function(n){n.preventDefault(),IWD.Signin.showLoader(),$j.post(IWD.Signin.config.url+"signin/yahoo/prepare",{},function(n){IWD.Signin.hideLoader(),"undefined"!=typeof n.error&&0==n.error&&IWD.Signin.openYahooDialog(n.url)},"json")})},openYahooDialog:function(n){var i=(screen.width-600)/2,o=(screen.height-435)/2;IWD.Signin.yahooDialog=window.open(n,"Yahoo","width=600,height=435,resizable=false,scrollbars=false,status=false,toolbar=false,left="+i+",top="+o+",status=no,toolbar=no,menubar=no"),IWD.Signin.yahooDialog.focus()},initTwitterLogin:function(){$j(document).on("click",".btn-twitter-login",function(n){n.preventDefault(),IWD.Signin.showLoader(),$j.post(IWD.Signin.config.url+"signin/twitter/prepare",{},function(n){IWD.Signin.hideLoader(),"undefined"!=typeof n.error&&1==n.error&&(IWD.Signin.showMessage(n.message),IWD.Signin.hideLoader()),"undefined"!=typeof n.error&&0==n.error&&IWD.Signin.openTwitterDialog(n.url)},"json")})},openTwitterDialog:function(n){var i=(screen.width-600)/2,o=(screen.height-435)/2;IWD.Signin.twitterDialog=window.open(n,"Twitter","width=600,height=435,resizable=false,scrollbars=false,status=false,toolbar=false,left="+i+",top="+o+",status=no,toolbar=no,menubar=no"),IWD.Signin.twitterDialog.focus()}},$j(document).ready(function(){IWD.Signin.init()});