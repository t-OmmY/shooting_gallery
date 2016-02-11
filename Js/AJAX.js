
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
                url: '../index.php',
                /* метод отправки данных */
                method: 'POST',
                /* данные, которые мы передаем в файл-обработчик */
                data: {"startFrom" : startFrom, ajax:true, controller:'admin', action:'ajax_contact_messages'},
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
                            "<i style='font-size: 14px'>" + messages.date + "</i><br><span style='font-size: 24px'>" + messages.name + "</span><span style='font-size: 20px'>&nbsp;write:</span> <footer><br><i style='font-size: 18px'>" +
                            messages.message + "</i><br><span style='font-size: 14px'>" + messages.email + "</span></footer></blockquote></div>"
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

//hit_print function
function hit_print (pass_to_pic, file_extension, color_name, x, y, shotWidth, shotHeight, picWidth, picHeight, title_x, title_y){
    $("#dinamicPic").append(
        "<div class='hits'>" +
        "<img src='" + pass_to_pic + color_name+ file_extension + "' style='position:absolute;left:"+ (Number(x)+picWidth/2-shotWidth/2+15) +"px;top:"+ (Number(y)+picHeight/2-shotHeight/2) +"px' title='x:&nbsp;"+ title_x +", y:&nbsp;"+ title_y +"' width='" + shotWidth + "px' height='" +  shotHeight + "px'>" +
        "</div>"
    )
}
//end of hit function
//params for hit
var picHeight = 600;
var picWidth = 600;
var coridor = 10;
var shotHeight = 30;
var shotWidth = 30;
var picPass = '../helpers/img/mycabinet/Hits/';
var picExtention = '.png';
//end of params
$(document).ready(function(){

    $('#sessionSelect').change(function() {
        $("#dinamicInfo").children().hide(800);
        $("#dinamicPic").children().hide(800);
        $.ajax({

            url: '../index.php',

            method: 'POST',

            data : { "session_id": $(this).val(), ajax: true, controller:'cabinet', action:'ajax_select_session' }

        }).done(function(session_info){
            session_info = jQuery.parseJSON(session_info);

            $("#dinamicInfo").append(
                "<h4>Session&nbsp;info</h4><div>" +
                "<i>date:&nbsp;</i>" + session_info.date +
                "<br><i>name:&nbsp;</i>" + session_info.session_name +
                "<br><i>target:&nbsp;</i>" + session_info.target_name +
                "<br><i>caliber:&nbsp;</i>" + session_info.caliber_name + "&nbsp;diameter&nbsp;" + session_info.caliber_diameter +
                "</div>");
            if (session_info.serie_list !== 'empty'){
                ad = 'advanture_distance_from_the_centre';
                var x0 = 'group_center_X';
                var y0 = 'group_center_Y';
                var r100 = 'circle_radius,_which_gets_100%_of_the_shots';
                var r50 = 'circle_radius,_which_gets_50%_of_the_shots';
                var sd = 'standard_deviation_of_the_distance_from_the_center';
                $("#dinamicInfo").append(
                    "<div id='statistic'><h4>Statistic:</h4><table id='statistic' border='1px' width='100%' style='text-align: center'><tr><td></td><td class='stat' data-title=" + ad + ">ad</td><td class='stat' data-title=" + x0 + ">x0</td><td class='stat' data-title=" + y0 + ">y0</td><td class='stat' data-title=" + r100 + ">r100</td><td class='stat' data-title=" + r50 + ">r50</td><td class='stat' data-title=" + sd + ">sd</td></tr></table><br></div>" +
                    "<div id='serie'><br>Serie list:&nbsp;"+
                    "<select name='serieSelect' id='dinamic_option'><option selected disabled>All series</option>" +
                    +
                        "</select>" +
                    "</div>"
                );
                $.each(session_info.serie_list, function(index, serie){
                    $("select#dinamic_option").append(
                        "<option value='"+serie.serie_id+"' style='color: " + serie.color_name + "'>"+ serie.number + "&nbsp;-&nbsp;" + serie.name + "</option>"
                    );
                    $("table#statistic").append(
                        "<tr><td style='background: " + serie.color_name + "'>&nbsp serie &nbsp" + serie.number + "&nbsp</td><td>&nbsp" + serie.ad + "&nbsp</td><td>&nbsp" + serie.x0 + "&nbsp</td><td>&nbsp" + serie.y0 + "&nbsp</td><td>&nbsp" + serie.r100 + "&nbsp</td><td>&nbsp" + serie.r50 + "&nbsp</td><td>&nbsp" + serie.sd + "&nbsp</td></tr>"
                    );

                });
                $("table#statistic").append(
                    "<tr style='color: #ff002b'><td>FULL SESSION</td><td>&nbsp" + session_info.ses_stat.ad + "&nbsp</td><td>&nbsp" + session_info.ses_stat.x0 + "&nbsp</td><td>&nbsp" + session_info.ses_stat.y0 + "&nbsp</td><td>&nbsp" + session_info.ses_stat.r100 + "&nbsp</td><td>&nbsp" + session_info.ses_stat.r50 + "&nbsp</td><td>&nbsp" + session_info.ses_stat.sd + "&nbsp</td></tr>"
                );

            } else {
                $("#dinamicInfo").append(
                "<b style='color: red'>EMPTY SESSION, no series here...</b>"
                );
            }
            $("#dinamicPic").append(
                "<div>" +
                "<img src=\"../helpers/img/mycabinet/Targets/" + session_info.target_name +".jpg\" width=" + picWidth + " height=" + picHeight + " style='opacity:0.8'>" +
                "</div>"
            );
            $.each(session_info.hits, function(index, hit){
                if (Number(hit.x)>picWidth/2) {
                    if (Number(hit.y)>picHeight/2){
                        hit_print(picPass,picExtention,hit.color_name,picWidth/2+coridor,picHeight/2+coridor,shotWidth,shotHeight,picWidth,picHeight,hit.x,hit.y)
                    } else if (Number(hit.y)<-picHeight/2){
                        hit_print(picPass,picExtention,hit.color_name,picWidth/2+coridor,-picHeight/2-coridor,shotWidth,shotHeight,picWidth,picHeight,hit.x,hit.y)
                    } else {
                        hit_print(picPass,picExtention,hit.color_name,picWidth/2+coridor,hit.y,shotWidth,shotHeight,picWidth,picHeight,hit.x,hit.y)
                    }
                } else if (Number(hit.x)<-picWidth/2){
                    if (Number(hit.y)<-picHeight/2){
                        hit_print(picPass,picExtention,hit.color_name,-picWidth/2-coridor,-picHeight/2-coridor,shotWidth,shotHeight,picWidth,picHeight,hit.x,hit.y)
                    } else if (Number(hit.y)>picHeight/2){
                        hit_print(picPass,picExtention,hit.color_name,-picWidth/2-coridor,picHeight/2+coridor,shotWidth,shotHeight,picWidth,picHeight,hit.x,hit.y)
                    } else {
                        hit_print(picPass,picExtention,hit.color_name,-picWidth/2-coridor,hit.y,shotWidth,shotHeight,picWidth,picHeight,hit.x,hit.y)
                    }
                } else if (Number(hit.y)>picHeight/2){
                    hit_print(picPass,picExtention,hit.color_name,hit.x,picHeight/2+coridor,shotWidth,shotHeight,picWidth,picHeight,hit.x,hit.y)
                } else if (Number(hit.y)<-picHeight/2){
                    hit_print(picPass,picExtention,hit.color_name,hit.x,-picHeight/2-coridor,shotWidth,shotHeight,picWidth,picHeight,hit.x,hit.y)
                } else {
                    hit_print(picPass,picExtention,hit.color_name,hit.x,hit.y,shotWidth,shotHeight,picWidth,picHeight,hit.x,hit.y)
                }
            });
        });
    });
});

$("body").on("change", "#dinamic_option", function () {
    $("div#serie_info").hide(800);
    $("div.hits").hide(800);
    $.ajax({

        url: '../index.php',

        method: 'POST',

        data : { "serie_id": $(this).val(), ajax: true, controller:'cabinet', action:'ajax_select_serie' }

    }).done(function(serie_info){
        serie_info = jQuery.parseJSON(serie_info);
        $("div#serie").append(
            "<div id='serie_info'>"+
            "<br><i>number:&nbsp;</i>" + serie_info.number +
            "<br><span style='color: " + serie_info.color_name + "'><i>color:&nbsp;</i>" + serie_info.color_name + "</span>" +
            "<br><i>name:&nbsp;</i>" + serie_info.name +
            "<br><i>comment:&nbsp</i>;" + serie_info.comment +
            "<br><i>firestyle:&nbsp;</i>" + serie_info.firestyle_name +
            "<br><i>scope:&nbsp;</i>" + serie_info.scope_name +
            "<br><i>range:&nbsp;</i>" + serie_info.range + "&nbsp;m"+
            "</div>"
        );
        $.each(serie_info.hits, function(index, hit){
            if (Number(hit.x)>picWidth/2) {
                if (Number(hit.y)>picHeight/2){
                    hit_print(picPass,picExtention,serie_info.color_name,picWidth/2+coridor,picHeight/2+coridor,shotWidth,shotHeight,picWidth,picHeight,hit.x,hit.y)
                } else if (Number(hit.y)<-picHeight/2){
                    hit_print(picPass,picExtention,serie_info.color_name,picWidth/2+coridor,-picHeight/2-coridor,shotWidth,shotHeight,picWidth,picHeight,hit.x,hit.y)
                } else {
                    hit_print(picPass,picExtention,serie_info.color_name,picWidth/2+coridor,hit.y,shotWidth,shotHeight,picWidth,picHeight,hit.x,hit.y)
                }
            } else if (Number(hit.x)<-picWidth/2){
                if (Number(hit.y)<-picHeight/2){
                    hit_print(picPass,picExtention,serie_info.color_name,-picWidth/2-coridor,-picHeight/2-coridor,shotWidth,shotHeight,picWidth,picHeight,hit.x,hit.y)
                } else if (Number(hit.y)>picHeight/2){
                    hit_print(picPass,picExtention,serie_info.color_name,-picWidth/2-coridor,picHeight/2+coridor,shotWidth,shotHeight,picWidth,picHeight,hit.x,hit.y)
                } else {
                    hit_print(picPass,picExtention,serie_info.color_name,-picWidth/2-coridor,hit.y,shotWidth,shotHeight,picWidth,picHeight,hit.x,hit.y)
                }
            } else if (Number(hit.y)>picHeight/2){
                hit_print(picPass,picExtention,serie_info.color_name,hit.x,picHeight/2+coridor,shotWidth,shotHeight,picWidth,picHeight,hit.x,hit.y)
            } else if (Number(hit.y)<-picHeight/2){
                hit_print(picPass,picExtention,serie_info.color_name,hit.x,-picHeight/2-coridor,shotWidth,shotHeight,picWidth,picHeight,hit.x,hit.y)
            } else {
                hit_print(picPass,picExtention,serie_info.color_name,hit.x,hit.y,shotWidth,shotHeight,picWidth,picHeight,hit.x,hit.y)
            }
        });
    });
});