define(['jquery',"popBox",'jquery_sanhai','validationEngine','validationEngine_zh_CN'],

    function($,popBox,jquery_sanhai,validationEngine,validationEngine_zh_CN) {

        $('form').validationEngine({
            validateNonVisibleFields: true,
            promptPosition: "centerRight",
            maxErrorsPerField: 1,
            showOneMessage: true,
            addSuccessCssClassToField: 'ok'
        });

    });