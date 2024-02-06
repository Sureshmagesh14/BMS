
<div class="modal-body">
   <div class="sharesurvey">
   <div class="ss-action-input--wrapper fx-column fx-ai--start fx--fw"><div class="fx-row fx-ai--start fx--fw"><div class="flex_column ss-form--input-group ss-form--input-group__no-padding ss-form--input-group__no-margin"><div class="fx-row fx-ai--stretch fx--fw"><input class="ss-form--input" type="text" id="shareLink" readonly="" value="{{$surveylink}}" style="border-radius: 5px;"></div></div><div class="ss-text__no-wrap"><a class="ss-button ss-button__primary mx--zero fx-jc--center" role="button" id="clickCopy" style="border-radius: 3px;">Copy URL<svg width="16" height="16" class="ms-3" fill="none" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg"><path d="M12 0.75H3C2.175 0.75 1.5 1.425 1.5 2.25V12.75H3V2.25H12V0.75ZM11.25 3.75H6C5.175 3.75 4.5075 4.425 4.5075 5.25L4.5 15.75C4.5 16.575 5.1675 17.25 5.9925 17.25H14.25C15.075 17.25 15.75 16.575 15.75 15.75V8.25L11.25 3.75ZM6 15.75V5.25H10.5V9H14.25V15.75H6Z" fill="#FFFFFF"></path></svg></a></div></div></div>
    <input type="text" value="{{$surveylink}}" id="myInput">

    </div>
</div>
<div id="shareContent" style="display:none;">
    {{$surveylink}}
</div>

<script>
document.getElementById("clickCopy").onclick = function () {
    copyToClipboard(document.getElementById("shareContent"));
};

function copyToClipboard(e) {
    var text_to_copy = document.getElementById("shareContent").innerHTML;

    if (!navigator.clipboard){
        // use old commandExec() way
    } else{
        navigator.clipboard.writeText(text_to_copy).then(
            function(){
                alert("URL Copied!"); // success 
            })
        .catch(
            function() {
                alert("Failed to Copy"); // error
        });
    } 
}
</script>
<style>
#myInput{
    visibility: hidden;
}
a {
    background-color: transparent;
}

input {
    font-family: inherit;
    font-size: 100%;
    line-height: 1.15;
    margin: 0;
}

input {
    overflow: visible;
}

body ::selection {
    color: #fff;
    background: rgba(55, 36, 89, 0.2);
}

body a {
    cursor: pointer;
}

.flex_column {
    display: -webkit-box;
    display: -webkit-flex;
    display: -moz-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-direction: normal;
    -webkit-box-orient: vertical;
    -webkit-flex-direction: column;
    -moz-flex-direction: column;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    -webkit-justify-content: center;
    -moz-justify-content: center;
    justify-content: center;
    -webkit-box-align: start;
    -ms-flex-align: start;
    -webkit-align-items: flex-start;
    -moz-align-items: flex-start;
    align-items: flex-start;
}

a {
    background-color: transparent;
}

input {
    font-family: inherit;
    font-size: 100%;
    line-height: 1.15;
    margin: 0;
}

input {
    overflow: visible;
}

div,
a {
    margin: 0;
    padding: 0;
    border: 0;
    font-size: 100%;
    font: inherit;
    vertical-align: baseline;
}

body *,
body *::after,
body *::before {
    box-sizing: border-box;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

body input:focus,
body a:focus {
    outline: none;
}

body a {
    cursor: pointer;
    text-decoration: none;
}

body a:hover {
    text-decoration: none;
}

:focus {
    outline: none;
}

:focus {
    outline: none !important;
}

body:not([dir='rtl']) .ms-3 {
    margin-left: 8px !important;
}

.ss-text__no-wrap {
    white-space: nowrap;
}

.ss-form--input-group {
    width: 100%;
    position: relative;
    padding: 0 0 16px;
    margin: 0 0 8px;
}

.ss-form--input-group.ss-form--input-group__no-padding {
    padding: 0;
}

.ss-form--input-group.ss-form--input-group__no-margin {
    margin: 0;
}

.ss-form--input-group .ss-form--input {
    height: 40px;
    width: 100%;
    color: #000;
    font-weight: 400;
    font-size: 16px;
    line-height: 20px;
    border-radius: 3px;
    border: thin solid #ededed;
    background-color: #fff;
    resize: none;
    transition: border 0.3s;
    overflow: hidden;
    text-overflow: ellipsis;
    padding: 0 .5em;
}

.ss-form--input-group .ss-form--input:focus {
    border: thin solid rgba(99, 104, 111, 0.4);
}

.ss-action-input--wrapper .ss-form--input {
    border-radius: 3px 0 0 3px;
    border-right: none;
}

.ss-action-input--wrapper .ss-form--input:focus {
    border-right: none;
}

.ss-action-input--wrapper .ss-button.ss-button__primary {
    border-radius: 0 3px 3px 0;
    border: none;
    height: 40px;
}

.ss-action-input--wrapper .ss-button.ss-button__primary:hover {
    border: none;
}

.ss-button {
    display: -webkit-inline-box;
    display: -webkit-inline-flex;
    display: -moz-inline-flex;
    display: -ms-inline-flexbox;
    display: inline-flex;
    -webkit-box-direction: normal;
    -webkit-box-orient: horizontal;
    -webkit-flex-direction: row;
    -moz-flex-direction: row;
    -ms-flex-direction: row;
    flex-direction: row;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    -webkit-justify-content: space-between;
    -moz-justify-content: space-between;
    justify-content: space-between;
    -webkit-box-align: center;
    -ms-flex-align: center;
    -webkit-align-items: center;
    -moz-align-items: center;
    align-items: center;
    padding: 10px 16px;
    margin: 0 .2em;
    font-size: 14px;
    font-weight: 600;
    line-height: 1.4;
    transition: all 0.3s;
    border-radius: 3px;
    position: relative;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    cursor: pointer;
    background: transparent;
    border: none;
}

.ss-button svg {
    vertical-align: middle;
    transition: all 0.3s;
    opacity: 0.8;
    line-height: inherit;
}

.ss-button:hover,
.ss-button:active,
.ss-button:focus {
    text-decoration: none;
    outline: none;
}

.ss-button:hover svg,
.ss-button:active svg,
.ss-button:focus svg {
    opacity: 1;
}

.ss-button.ss-button__primary {
    color: #fff;
    background-color: #4A9CA6;
    border: thin solid #4A9CA6;
}

.ss-button.ss-button__primary:hover,
.ss-button.ss-button__primary:active,
.ss-button.ss-button__primary:focus {
    color: #fff;
    border: thin solid #448E97;
    background-color: #448E97;
}

.flex_column {
    display: -webkit-box;
    display: -webkit-flex;
    display: -moz-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-direction: normal;
    -webkit-box-orient: vertical;
    -webkit-flex-direction: column;
    -moz-flex-direction: column;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    -webkit-justify-content: center;
    -moz-justify-content: center;
    justify-content: center;
    -webkit-box-align: start;
    -ms-flex-align: start;
    -webkit-align-items: flex-start;
    -moz-align-items: flex-start;
    align-items: flex-start;
}

.fx-row {
    display: -webkit-box;
    display: -webkit-flex;
    display: -moz-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-direction: normal;
    -webkit-box-orient: horizontal;
    -webkit-flex-direction: row;
    -moz-flex-direction: row;
    -ms-flex-direction: row;
    flex-direction: row;
    -webkit-box-align: center;
    -ms-flex-align: center;
    -webkit-align-items: center;
    -moz-align-items: center;
    align-items: center;
}

.fx-column {
    display: -webkit-box;
    display: -webkit-flex;
    display: -moz-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-direction: normal;
    -webkit-box-orient: vertical;
    -webkit-flex-direction: column;
    -moz-flex-direction: column;
    -ms-flex-direction: column;
    flex-direction: column;
}

.fx-jc--center {
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    -webkit-justify-content: center;
    -moz-justify-content: center;
    justify-content: center;
}

.fx-ai--start {
    -webkit-box-align: start;
    -ms-flex-align: start;
    -webkit-align-items: flex-start;
    -moz-align-items: flex-start;
    align-items: flex-start;
}

.fx-ai--stretch {
    -webkit-box-align: stretch;
    -ms-flex-align: stretch;
    -webkit-align-items: stretch;
    -moz-align-items: stretch;
    align-items: stretch;
}

.mx--zero {
    margin: 0;
}

.fx--fw {
    width: 100%;
}

*:focus {
    outline: none !important;
}

body * {
    font-family: "Source Sans Pro", sans-serif;
}

/*! CSS Used from: Embedded */
*,
*::before,
*::after {
    -webkit-box-sizing: inherit;
    box-sizing: inherit;
}

::selection {
    background: rgba(125, 188, 255, 0.6);
}

a {
    color: #106ba3;
    text-decoration: none;
}

a:hover {
    color: #106ba3;
    cursor: pointer;
    text-decoration: underline;
}

:focus {
    outline: rgba(19, 124, 189, 0.6) auto 2px;
    outline-offset: 2px;
    -moz-outline-radius: 6px;
}
.sharesurvey {
    padding: 10px;
}
</style>
