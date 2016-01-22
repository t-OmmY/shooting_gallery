
$(document).ready(function(){

    /* Переменная-флаг для отслеживания того, происходит ли в данный момент ajax-запрос. В самом начале даем ей значение false, т.е. запрос не в процессе выполнения */
    var inProgress = false;
    /* С какой статьи надо делать выборку из базы при ajax-запросе */
    var startFrom = 5;

    /* Используйте вариант $('#more').click(function() для того, чтобы дать пользователю возможность управлять процессом, кликая по кнопке "Дальше" под блоком статей (см. файл index.php) */
    $(window).scroll(function() {

        /* Если высота окна + высота прокрутки больше или равны высоте всего документа и ajax-запрос в настоящий момент не выполняется, то запускаем ajax-запрос */
        if($(window).scrollTop() + $(window).height() >= $(document).height() - 200 && !inProgress) {

            $.ajax({
                /* адрес файла-обработчика запроса */
                url: '../Library/AJAXobrabotchik.php',
                /* метод отправки данных */
                method: 'POST',
                /* данные, которые мы передаем в файл-обработчик */
                data: {"startFrom" : startFrom},
                /* что нужно сделать до отправки запрса */
                beforeSend: function() {
                    /* меняем значение флага на true, т.е. запрос сейчас в процессе выполнения */
                    inProgress = true;}
                /* что нужно сделать по факту выполнения запроса */
            }).done(function(messages){

                /* Преобразуем результат, пришедший от обработчика - преобразуем json-строку обратно в массив */
                messages = jQuery.parseJSON(messages);

                /* Если массив не пуст (т.е. статьи там есть) */
                if (messages.length > 0) {

                    /* Делаем проход по каждому результату, оказвашемуся в массиве,
                     где в index попадает индекс текущего элемента массива, а в data - сама статья */
                    $.each(messages, function(index, messages){

                        /* Отбираем по идентификатору блок со статьями и дозаполняем его новыми данными */
                        $("#articles").append("<div class='col-md-12 col-md-offset-0'>" +
                            "<blockquote>"+
                            "<i style='font-size: 10px'>" + messages.date + "</i><br>" + messages.name + "<span style='font-size: 14px'>&nbsp;write:</span> <footer><br><i>" +
                            messages.message + "</i><br><span style='font-size: 10px'>" + messages.email + "</span></footer></blockquote></div>"
                        );
                    });

                    /* По факту окончания запроса снова меняем значение флага на false */
                    inProgress = false;
                    // Увеличиваем на 10 порядковый номер статьи, с которой надо начинать выборку из базы
                    startFrom += 5;
                }
            });
        }
    });
});


$(document).ready(function(){

    $('#sessionSelect').change(function() {
        $("#dinamicInfo").children().hide(800);
        $("#dinamicPic").children().hide(800);
        $.ajax({

            url: '../Library/AJAXselectSession.php',

            method: 'POST',

            data : { "session_id": $(this).val() }

        }).done(function(session_info){
            session_info = jQuery.parseJSON(session_info);
            $("#dinamicInfo").append(
                "<h4>Session&nbsp;info</h4><div class'col-xs-4'>" +
                "date:&nbsp;" + session_info.date +
                "<br>name:&nbsp;" + session_info.session_name +
                "<br>target:&nbsp;" + session_info.target_name +
                "<br>caliber:&nbsp;" + session_info.caliber_name + "&nbsp;diameter&nbsp;" + session_info.caliber_diameter +
                "</div>"
            );
            $("#dinamicPic").append(
                "<div class'col-xs-6'>" +
                "<img src=\"../helpers/img/mycabinet/Targets/" + session_info.target_name +".jpg\" width='600px'>" +
                "</div>"
            );
            $.each(session_info.hits, function(index, hit){
                $("#dinamicPic").append(
                    "<div class'col-xs-6'>" +
                    "<img src='../helpers/img/mycabinet/Pointers/"+ hit.color_name+".png' style='position:absolute;left:"+ (Number(hit.x)+15-20) +"px;top:"+ (Number(hit.y)-50) +"px' title='x:&nbsp;"+ hit.x +", y:&nbsp;"+ hit.y +"' width='40px' height='50px'>" +
                    "</div>"
                )
            });
        });
    });
});

