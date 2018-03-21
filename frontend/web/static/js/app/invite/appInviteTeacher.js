$(function () {
    $('#btn').click(function (ev) {
        var inviteeName = $('#inviteeName input').val();
        var inviteePhone = $('#inviteePhone input').val();
        var inviteCode = $('#inviteCode input').val();

        var hint = $('#hint');

        function show(text) {
            hint.html(text);
            hint.css('display', 'block');
            setTimeout(hide, 1000)
        }

        function hide() {
            hint.css('display', 'none');
        }

        if (!inviteeName.trim()) {
            show('姓名不能为空');
            return;
        }

        if (inviteeName.trim().length > 20 ) {
            show('姓名长度过长');
            return;
        }
        if (!inviteePhone.trim()) {
            show('联系方式不能为空');
            return;
        }

        var reg = /^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$/;
        if (!reg.test(inviteePhone)) {
            show('请输入正确的手机号');
            return;
        }

        $.post('/mobiles/invite/save-invite-teacher', {
            inviteeName: inviteeName,
            inviteePhone: inviteePhone,
            inviteCode: inviteCode
        }, function (data) {

            if (data.success) {
                $('#hint1').show();
            } else {
                show(data.message);
            }
        });
    });
    $('#hint1').on('click', 'p', function () {
        $('#hint1').hide();
        $('input').val('');
    });


    $('#apply').click(function (ev) {
        var applyName = $('#applyName').val();
        var applyPhone = $('#applyPhone').val();

        var hint = $('#hint');


        if (!applyName.trim()) {
            alert('姓名不能为空');
            return;
        }

        if (applyName.trim().length > 20 ) {
            alert('姓名长度过长');
            return;
        }
        if (!applyPhone.trim()) {
            alert('联系方式不能为空');
            return;
        }

        var reg = /^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$/;
        if (!reg.test(applyPhone)) {
            alert('请输入正确的手机号');
            return;
        }

        $.post('/mobiles/apply/save-apply-teacher', {
            applyName: applyName,
            applyPhone: applyPhone
        }, function (data) {

            if (data.success) {
                $('#hint1').show();
            } else {
                alert(data.message);
            }
        });
    });


})
function userDefImg(image) {
    image.src = '/pub/images/tx.jpg';
    image.onerror = null;
}