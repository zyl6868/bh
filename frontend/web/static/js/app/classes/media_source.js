$(function () {

    var audioBox = $('.audioBox')
    var volArr = ['vol', 'vol a b', 'vol a']
    var volIndex = 0
    var audio, vol, interval

    function audioPlay() {
        var a = $('.audioBox')
        for(var i = 0, len = a.length; i < len; i++) {
            audioPause(a.eq(i))
        }

        volIndex = 0

        audio.play()

        // 倒计时
        interval = setInterval(function () {
            if (volIndex === 3) {
                volIndex = 0
            }
            if (audio.paused) {
                clearInterval(interval)
                volIndex = 0
            }
            vol.attr('class', volArr[volIndex++])
        }, 500)
    }

    function audioPause(audioBox) {
        clearInterval(interval)
        audioBox.find('.vol').eq(0).attr('class', volArr[0])
        audioBox.find('audio')[0].load()
    }

    $(document).on('click','.audioBox', function () {
        audio = $(this).find('audio')[0]
        vol = $(this).find('.vol').eq(0)
        if (audio.paused) {
            audioPlay()
        } else {
            audioPause($(this))
        }
    })
})