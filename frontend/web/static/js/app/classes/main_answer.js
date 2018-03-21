require.config({
    baseUrl: '../dev/js',
    paths: {
        jquery: 'jquery',
        answer:'app/classes/answer',
        sanhai_tools:'lib/jquery.sanhai',
        popBox:'module/popBox'
    }
});
require(['jquery','answer','sanhai_tools']);
