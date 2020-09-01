<?php
echo $before_widget;

if ($heading) {
    echo $before_title . $heading . $after_title;
}

?>

<div>
    <div class="ag-form mb1">
        <div style="position: relative;">
            <input style="width: 100%; height: 44px; background: #eee;" name="" value="" id="ag-generated-secure-pwd">
            <div class="ag-tooltip">
                <button class="ag-password-copy-btn" id="ag-generated-secure-pwd-copy">
                    <span class="ag-tooltiptext" id="ag-generated-secure-pwd-copy-tooltip"><?php esc_attr_e('Copy to clipboard'); ?></span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18">
                        <path fill="none" d="M0 0h24v24H0z" />
                        <path d="M7 6V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1h-3v3c0 .552-.45 1-1.007 1H4.007A1.001 1.001 0 0 1 3 21l.003-14c0-.552.45-1 1.007-1H7zM5.003 8L5 20h10V8H5.003zM9 6h8v10h2V4H9v2z" fill="rgba(153,153,153,1)" /></svg>
                </button>

            </div>
            <div class="ag-tooltip-2">
                <button class="ag-password-copy-btn" id="ag-regenerate-pwd">
                    <span class="ag-tooltiptext-2" id="ag-generated-secure-pwd-regenerate-tooltip"><?php esc_attr_e('Regenerate'); ?></span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18">
                        <path fill="none" d="M0 0h24v24H0z" />
                        <path d="M5.463 4.433A9.961 9.961 0 0 1 12 2c5.523 0 10 4.477 10 10 0 2.136-.67 4.116-1.81 5.74L17 12h3A8 8 0 0 0 6.46 6.228l-.997-1.795zm13.074 15.134A9.961 9.961 0 0 1 12 22C6.477 22 2 17.523 2 12c0-2.136.67-4.116 1.81-5.74L7 12H4a8 8 0 0 0 13.54 5.772l.997 1.795z" fill="rgba(153,153,153,1)" /></svg>
                </button>

            </div>
        </div>
        <div class="form-group" style="margin-bottom: 0px;">
            <label for="ag-pwdlength">Password length: <span id="ag-length"></span></label><br />
            <input id="ag-pwdlength" type="range" name="ag-pwdlength" value="8" min="0" max="99" step="1">

            <div>
                <div id="ag-strength-1" class="weak" style="display: inline-block; width: 35px; height: 5px;"></div>
                <div id="ag-strength-2" class="inactive" style="display: inline-block; width: 35px; height: 5px;"></div>
                <div id="ag-strength-3" class="inactive" style="display: inline-block; width: 35px; height: 5px;"></div>
                <div id="ag-strength-4" class="inactive" style="display: inline-block; width: 35px; height: 5px;"></div>
            </div>

        </div>
        <div class="form-group">
            <input type="checkbox" name="ag-characters" value="lowercase" checked>
            <label for="lowercase"><?php esc_attr_e('smallcase letters'); ?></label><br />

            <input type="checkbox" name="ag-characters" value="uppercase" checked>
            <label for="uppercase"><?php esc_attr_e('uppercase letters'); ?></label><br />

            <input type="checkbox" name="ag-characters" value="numbers">
            <label for="numbers"><?php esc_attr_e('numbers'); ?></label><br />

            <input type="checkbox" name="ag-characters" value="symbols">
            <label for="symbols"><?php esc_attr_e('special symbols'); ?></label>
        </div>
        <div id="ag-errorbox">

        </div>
    </div>
</div>

<?php

echo $after_widget;
