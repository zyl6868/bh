require.config({
    paths: {
        "classes_memorabilia":"app/classes/classes_memorabilia",
        'classes_album':'app/classes/classes_album',
        'classes_answering_question':'app/classes/classes_answering_question',
        'classes_file':'app/classes/classes_file',
        'classes_index':'app/classes/classes_index',
        'classes_member':'app/classes/classes_member'
    }
});

define([
        'classes_index',
        'classes_album',
        'classes_memorabilia',
        'classes_member','classes_file',
        'classes_answering_question'
    ],
    function(
        classes_index,
        classes_album,
        classes_memorabilia,
        classes_member,
        classes_file,
        classes_answering_question
    )
    {
        classes_index.init();
        classes_memorabilia.init();
        classes_album.init();
        classes_member.init();
        classes_file.init();
        classes_answering_question.init()

    });
