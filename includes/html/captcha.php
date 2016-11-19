<?php
if(USE_CAPTCHA=="true"){
 
?>
<script type="text/javascript">
var RecaptchaOptions = {
theme : 'custom',
custom_theme_widget: 'recaptcha_widget'
};
</script>
 
<div id="recaptcha_widget" style="display:none">
    <div class="control-group">
        
        <div class="controls">
            <a id="recaptcha_image" href="#" class="thumbnail"></a>
          
        </div>
    </div>
 
    <div class="control-group">
            <label class="recaptcha_only_if_image control-label">Enter the words above:</label>
            <label class="recaptcha_only_if_audio control-label">Enter the numbers you hear:</label>
     
            <div class="controls">
                <div class="input-append pull-left">
                    <input type="text" id="recaptcha_response_field" class="input-recaptcha" name="recaptcha_response_field" />
                    <a class="btn" href="javascript:Recaptcha.reload()"><i class="icon-refresh"></i></a>
                    <a class="btn recaptcha_only_if_image" href="javascript:Recaptcha.switch_type('audio')"><i title="Get an audio CAPTCHA" class="icon-headphones"></i></a>
                    <a class="btn recaptcha_only_if_audio" href="javascript:Recaptcha.switch_type('image')"><i title="Get an image CAPTCHA" class="icon-picture"></i></a>
                    <a class="btn" href="javascript:Recaptcha.showhelp()"><i class="icon-question-sign"></i></a>
                </div>
                <div class="alert alert-block "><span id="ad_captcha_errmsg"></span></div>
                <div class='clearfix'></div>
            </div>
    </div>
</div>
 
<script type="text/javascript" src="https://www.google.com/recaptcha/api/challenge?k=<?php echo RECAPKEY_PUBLIC;?>"></script>
 



<?php }?>