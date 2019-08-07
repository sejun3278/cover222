$(window).scroll(  
    function(){  
        //스크롤의 위치가 상단에서 450보다 크면  
        if($(window).scrollTop() > 80) {
        /* if(window.pageYOffset >= $('원하는위치의엘리먼트').offset().top){ */  
            $('.category_tools').addClass("fix");
            $('#cart_top').css({ 'display' : 'block' })
            $('#cart_total_price_top').css({ 'display' : 'none' })
            
            //위의 if문에 대한 조건 만족시 fix라는 class를 부여함  
        }else{  
            $('.category_tools').removeClass("fix");  
            $('#cart_top').css({ 'display' : 'none' })
            $('#cart_total_price_top').css({ 'display' : 'block' })

            //위의 if문에 대한 조건 아닌경우 fix라는 class를 삭제함  
        }  
    } 
);

$(document).ready( () => {
    var url = '';
    window.onload = function() {
        //전체주소
        url = $(location);
        return url;
    }

    $.getJSON('category.json', function(data) {
        var html = [];

        $.each(data, function(i, item) {
          item.category.forEach( (el, key) => {
              if(key === 0) {
                html.push('<option class="' + el.name +' ' + key +'" checked="checked" name=' + el.name + '>' + el.name + '</option>')

              } else {
                html.push('<option class="' + el.name +' ' + key +'" name=' + el.name + '>' + el.name + '</option>')
              }
          })
        })
        $('#write_category_list').html(html.join(''));
        childChange();
    })

    function childChange() {
        let category = $('#write_category_list').val();
        if(category !== undefined) {
            let index = $('.' + category)[0].classList[1];

        $.getJSON('category.json', function(data) {
            var html = [];

            data[0].category[index].child.forEach( (el) => {
                html.push('<option> ' + el + ' </option>');
            })

            $('#write_child_list').html(html.join(''));
        });
      }
    }

    $('#write_category_list').change( () => {
        childChange();
    })

    if($('.item_total_num')[0] !== undefined) {
        $total_num = Number($('.item_total_num')[0].classList[1]); // 구매 갯수
        $('.item_total_num').val($total_num);
    }


    $('.ar').bind('mouseover', (event) => {
        $(event.currentTarget).css({ 'background-color' : '#768F9C' });
    
    }).bind('mouseleave', () => {
        $(event.currentTarget).css({ 'background-color' : 'white' });
    
    }).bind('click', (event) => {
        let type = $(event.currentTarget)[0].classList[0];
        let num = Number($('.item_total_num')[0].classList[1]);
        let price = Number($('.topic_price')[0].classList[1]); // 물품 금액
        let val = Number($('.item_total_num').val());

        if(type === 'ar_left') { // 더하기
            if(val >= 999) {
                return alert('더이상 추가할 수 없습니다.');
            }

            num = num + 1;
            $('.item_total_num')[0].classList.remove(String(num - 1));

        } else if(type === 'ar_right') { // 빼기
            if(num === 0) {
                return alert('0개 미만으로는 할 수 없습니다.');            
            }

            num = num - 1;    
            $('.item_total_num')[0].classList.remove(String(num + 1));
        }
        
        let result = price * num;
        $('.item_total_num')[0].classList.add(num);
        $('.item_total_num').val(num);
        $('#buy_total_price').html(String(result).replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,'));
    })

    $('.item_total_num').change( () => {
        let val = Number($('.item_total_num').val());
        let price = Number($('.topic_price')[0].classList[1]); // 물품 금액

        let total = price * val;
        let before = $('.item_total_num')[0].classList[1];
        $('.item_total_num')[0].classList.remove(before);

        if(val < 0) {
            total_original(0);
            return alert('0개 미만으로는 설정할 수 없습니다.');
        }

        if(isNaN(total)) {
            total_original(0);
            return alert('숫자만 입력 가능합니다.');
        }

        $('.item_total_num')[0].classList.add(val);
        $('#buy_total_price').html(String(total).replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,'));

    })

    function total_original(total) {
        $('.item_total_num')[0].classList.add(0);
        $('.item_total_num').val(0);
        $('#buy_total_price').html(String(total).replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,'));
    }

});

$('#signup_button').bind('click', () => {
    let id = document.getElementById('signup_id').value.trim();
    let nickname = document.getElementById('signup_nick').value.trim();
    let password = document.getElementById('signup_pass').value.trim();
    let confirm = document.getElementById('signup_confirm').value.trim();

    $(document).ready( () => {
        type = $('input[name="user_type"]:checked').val();
    })

    let select_array = ['signup_id', 'signup_nick', 'signup_pass', 'signup_confirm'];
    let str_array = ['id', 'nickname', 'password', 'confirm'];

    var id_check, nick_check;
    var allow = true;

    select_array.forEach( (el, key) => {
        let val = document.getElementById(el).value.trim();
        let $alert = '';

        if(val.length === 0) {
            allow = false;

            if($('#alert_' + str_array[key])[0] === undefined) {
             $alert = `<div class='signup_alert b' id='alert_${str_array[key]}'> * 최소 1글자 이상, 10글자 이하로 입력해야 합니다. </div>`;
             $('#signup_' + str_array[key] +'_div').append($alert);

            } else {
                $('#alert_' + str_array[key]).css({ 'font-weight' : 'bold' });
            }
            return;

        } else {
            $('#alert_' + str_array[key]).remove();

            if(str_array[key] === 'confirm') {
                if(password !== confirm) {
                    allow = false;
                    $alert = `<div class='signup_alert b' id='alert_${str_array[key]}'> * 비밀번호가 일치하지 않습니다. </div>`;
                    return $('#signup_' + str_array[key] +'_div').append($alert);
                }
            }
        }    
    })

    function check_id_nick(el, type) {
        const data = { data : el, position : type };
        var res = false;
        
        $.ajax({
            url : "signup_check.php",
            type : "post",
            data : data,
            async : false,
            success : ( (result) => {

                if(result === '') {
                    // 중복되지 않는 경우
                    res = true;
                    return res;
                }
            })
        });
        return res;
    }

    id_check = check_id_nick(id, 'user_id');
    nick_check = check_id_nick(nickname, 'nickname');

    if(!id_check) {
        $('#alert_id').remove();
        allow = false;
        $alert = `<div class='signup_alert b' id='alert_id'> * 이미 사용중인 아이디입니다. </div>`;
        $('#signup_id_div').append($alert);
    }

    if(!nick_check) {
        $('#alert_nickname').remove();
        allow = false;
        $alert = `<div class='signup_alert b' id='alert_nickname'> * 이미 사용중인 닉네임입니다. </div>`;
        $('#signup_nickname_div').append($alert);
    }

    if(allow) {
        $('.signup_form_div').fadeOut('500');
        setTimeout( () => {
            if(type === 'buyer') {
                $('.signup_none_buyer').css({ 'display' : 'block' });

            }  else {
                $('.signup_none_seller').css({ 'display' : 'block' });
            }
        }, 500);
    }
})

$('#login_button').bind('click', () => {
    let id = $('.login_id').val().trim();
    let password = $('.login_pass').val().trim();
    
    let allow = true;
    let $alert = '';

    let str_array = ['id', 'password'];
    let val_array = [id, password];

    str_array.forEach( (el, key) => {
        if(val_array[key].length === 0) {
            $('#alert_' + el).remove();
            allow = false;

            $alert = `<div class='login_alert b alert_${el}' id='alert_${el}'> * 최소 1글자 이상, 10글자 이하로 입력해야 합니다. </div>`;
            $('#login_' + el + '_div').append($alert);

            $('.login_alert').bind('click', (event) => {
                let select = $(event.currentTarget)[0].classList[2];
                $('#' + select).remove();
            })
        }
    })
    
    $('.login_input').bind('click', (event) => {
        let val = $(event.currentTarget)[0].classList[1];
        $('#' + val).remove();
    })

    $('.login_fail_alert').remove();
    if(allow) {

        const data = { id : id, password : password };

        $.ajax({
            url : "login_check.php",
            type : "post",
            data : data,
            // async : false,
            success : ( (result) => {
                if(result === '0') {
                    
                    $alert = `<div class='login_fail_alert b' id='alert_fail'> * 아이디 및 비밀번호를 다시 확인하십시오. </div>`;
                    return $('.login_tool').append($alert);

                } else if(result === 'true') {
                    alert('반갑습니다, ' + id + '님!');
                    return window.location.replace('index.php');
                }
            })
        });
    }
})


$('#category_img').bind('click', () => {
    category_open();
})

$('#category_label').bind('click', () => {
    category_open();
})

function category_open() {

    if($('.modal_background')[0] === undefined) {
        let $back = `<div class='modal_background'> 
                    </div>`
        $('#user_index_div').append($back);

        let $title = `<h2 id='cateogry_title'> Category 
                      <a class='point'> <img src='./source/close.png' id='category_close'> </a>
                      </h2> <hr /> 
                      <div id='category_list_tool'> 
                        <div id='category_lists'> </div>
                        <div id='category_child_lists'> </div>
                      </div>`;
        $('.modal_background').append($title);

        $('#category_close').bind('click', () => {
            $('.modal_background').remove();
        })

        $.getJSON('category.json', function(data) {
            var html = [];

            $.each(data, function(i, item) {
                item.category.forEach( (el, key) => {
                    html.push('<div class="category_list_grid">');
                    html.push('<div> <a class="category_lists ' + key + '">' + el.name + '</a> </div>');
                    html.push('<div> <a class="category_angel_click '+ key +'"> <img class="category_angel ' + key + '" src="https://iconmonstr.com/wp-content/g/gd/makefg.php?i=../assets/preview/2018/png/iconmonstr-angel-down-thin.png&r=255&g=255&b=255"/> </a> </div>')
                    html.push('</div>');
                })
                
                $('#category_lists').html(html.join(''));
            })

            $('.category_angel_click').bind('click', (event) => {
                var num = $(event.currentTarget)[0].classList[1];
                for(let i = 0; i < $('.category_angel_click').length; i++) {
                    if(Number(num) !== i) {
                        $('.category_angel_click')[i].classList.remove('on');
                        $('.category_lists.' + i).css({ 'color' : 'white', 'font-weight' : '100' })
                        $('.category_angel.' + i).attr({ 'src' : 'https://iconmonstr.com/wp-content/g/gd/makefg.php?i=../assets/preview/2018/png/iconmonstr-angel-down-thin.png&r=255&g=255&b=255' });
                    }
                }
                $('#category_child_lists').html('');

                if(!$(event.currentTarget)[0].classList.contains('on')) {
                    $(event.currentTarget)[0].classList.add('on');
                    $('.category_lists.' + num).css({ 'color' : 'powderblue', 'font-weight' : 'bold' });

                    $('.category_angel.' + num).attr({ 'src' : 'https://iconmonstr.com/wp-content/g/gd/makefg.php?i=../assets/preview/2018/png/iconmonstr-angel-up-thin.png&r=255&g=255&b=255' });
                    $('#category_child_lists').css({ 'border-left' : 'solid 1px white' });

                    data[0].category[num].child.forEach( (el) => {
                        $('#category_child_lists').append('<div class="category_child_list"> <a class="point">' + el + '</a> </div>')
                    })

                } else {
                    $('.category_angel_click.' + num)[0].classList.remove('on');
                    $('.category_lists.' + num).css({ 'color' : 'white', 'font-weight' : '100' })
                    $('.category_angel.' + num).attr({ 'src' : 'https://iconmonstr.com/wp-content/g/gd/makefg.php?i=../assets/preview/2018/png/iconmonstr-angel-down-thin.png&r=255&g=255&b=255' });

                    $('#category_child_lists').css({ 'border-left' : 'none' });
                    $('#category_child_lists').html('');
                }


            })
        });

    } else {
        $('.modal_background').remove();
    }
    }

$('.plz_login').bind('click', (event) => {
    let type = $(event.currentTarget)[0].classList[1];

    $.ajax({
        url : "check_login.php",
        type : "get",
        async : false,
        success : ( (result) => {
            if(result === 'false') {
                alert('로그인이 필요합니다.')
                return window.location.replace('login.php');
            }
        })
    })

    return window.location.replace(type + '.php');
})

function file_check(file, size) {
    let offset = $('.write_price_div').offset();
    const check = ['IMAGE/JPG', 'IMAGE/JPEG', 'IMAGE/PNG', 'IMAGE/GIF'];

    if(offset !== null) {
        $('html').animate({scrollTop : offset.top}, 400);
    }

    if(!check.includes(file.type.toUpperCase())) {
        alert('이미지 확장자 (jpg(e), png, gif)만 가능합니다.');
        return false;
        
    } else if(file.size > size) {
        alert(String(size).slice(0, 1) + 'MB 미만의 크기의 파일만 가능합니다.');
        return false;
    }

    return true;
}

$('#write_submit').bind('click', () => {
    const select_arr = ['write_title_div', 'write_textarea_div', 'write_price_div'];
    select_arr.forEach( (el) => {
        $('.' + el)[0].classList.remove('alert');
    })
    $('.write_alert').remove();

    let category = $('#write_category_list').val();
    let child = $('#write_child_list').val();

    let title = $('#write_title_input').val().trim();
    let contents = $('#write_textarea').val().trim();
    let price = $('#write_price').val().trim();
    let file = $('#write_file_input')[0].files[0];

    const val_arr = [title, contents, price];
    let $alert = '';

    let offset = $('.write_price_div').offset();

    if(isNaN(Number(price)) || price.length >= 9) {
        if(isNaN(Number(price))) {
            $alert = '<div class="b write_alert"> * 숫자로만 입력해주세요. </div>';

        } else if(price.length >= 9) {
            $alert = '<div class="b write_alert"> * 1억 미만의 금액만 가능합니다. </div>';
        }

        $('.write_price_div')[0].classList.add('alert');
        $('.write_price_div').append($alert);
        return $('html').animate({scrollTop : offset.top}, 400);
    }

    if(title.length === 0 || contents.length === 0 || price.length === 0) {
        $alert = '<div class="b write_alert"> * 최소 1글자 이상 입력해야 합니다. </div>';

        val_arr.forEach( (el, key) => {
            if(el.length === 0) {
                if(select_arr[key] === 'write_price_div') {
                    $alert = '<div class="b write_alert"> * 최소 1원 이상 입력해야 합니다. </div>';

                    $('html').animate({scrollTop : offset.top}, 400);
                }

                if(!$('.' + select_arr[key])[0].classList.contains('alert')) {
                    $('.' + select_arr[key])[0].classList.add('alert');
                    $('.' + select_arr[key]).append($alert);
                }
            }
        })

    } else {
        // 이미지 파일이 있는 경우
        let offset = $('.write_file_upload_div').offset();
        var fileName = '';

        if(file !== undefined) {
            if(file.name.length > 0) {

                if(!file_check(file, 5000000)) {
                    return;
                };
                fileName = file.name;
            }

        } else {
            fileName = null;
        }

        var formData = new FormData();
        formData.append('category', category);
        formData.append('child', child);
        formData.append('title', title);
        formData.append('contents', contents);
        formData.append('file', file);
        formData.append('fileName', fileName);
        formData.append('price', price);

        $.ajax({
            url : "write_update.php?files",
            type : "post",
            data : formData,
            contentType: false,
            processData: false,
            // contentType: 'multipart/form-data',
            // dataType: 'json',
            cache: false,

        }).done( (result) => {
            if(result === 'true') {
                alert('글 작성이 완료되었습니다.');
                return window.location.replace('index.php');
            }
        })
    }
})

$('.topic_like_div').bind('mouseover', () => {
    $('.topic_like_toggle').css({ 'color' : 'black' });

}).bind('mouseleave', () => {
    $('.topic_like_toggle').css({ 'color' : '#ababab' });

}).bind('click', (event) => {
    let user_id = $(event.currentTarget)[0].classList[1];
    let topic_id = $(event.currentTarget)[0].classList[2];
    
    let allow = plz_login();
    if(allow) {
    const data = { user_id : user_id, topic_id : topic_id };
    $.ajax({
        url : "toggle_like.php",
        type : "post",
        data : data,

    }).done( (result) => {
        if(result === "true") {
            alert('찜 리스트에 추가했습니다.');
            return window.location.replace('topic.php?id=' + topic_id);

        }  else {
            alert('찜 리스트에서 제거했습니다.');
            return window.location.replace('topic.php?id=' + topic_id);
        }
    })
    };
})

function plz_login() {
    let allow = true;
    $.ajax({
        url : "check_login.php",
        async : false,

    }).done( (result) => {
        if(result === 'false') {
            allow = false;
        }
    })

    if(!allow) {
        alert('로그인이 필요합니다.');
        window.location.replace('login.php');
        return false;
    }
    return allow;
}

function add_cart(id) {
    let allow = plz_login();
    if(!allow) {
        return;
    }

    let num = Number($('.item_total_num').val());
    if(num === 0 && allow !== false) {
        return alert('최소 1개 이상일 때 추가할 수 있습니다.');
    }

    let data = { topic_id : id, num : num, type : 'add' };

    function clear_cart() {
        $div = `<div class='propmt_cart'> 품목이 장바구니에 추가되었습니다. 
                    <br /> 장바구니로 이동할까요? <hr />
                    <div id='prompt_cart_grid'>
                      <div> <a href='cart.php' class='prompt_select add_cart_'> <img id='add_cart_' class='prompt_cart_img' src='./source/add_cart_gray.png'/> 장바구니로 </a> </div>
                      <div> <a class='prompt_select shopping_' id='keep_going_shopping'> <img id='shopping_' class='prompt_cart_img' src='./source/shopping_gray.png'/> 계속 쇼핑하기 </a> </div>
                    </div>
                   </div>`
        return $div;
    }; 

    function cart_prompt_cheat() {
       $('.prompt_select').bind('mouseover', (event) => {
            $(event.currentTarget).css({ color : 'black', 'font-weight' : 'bold' });

            let check = $(event.currentTarget)[0].classList[1];
            $('#' + check).attr({ 'src' : './source/' + check + 'black.png' })

        }).bind('mouseleave', (event) => {
            $(event.currentTarget).css({ color : '#ababab', 'font-weight' : '100' });
            
            let check = $(event.currentTarget)[0].classList[1];
            $('#' + check).attr({ 'src' : './source/' + check + 'gray.png' });              
        })

        $('#keep_going_shopping').bind('click', () => {
            return window.location.reload();
        })
    }

    $.ajax({
        url : "add_cart.php",
        type : "post",
        data : data,

    }).done( (result) => {
        if(result === 'true') {
            $('#buy_item_selector_div').append(clear_cart());

        } else if(result === 'false') {
            $div = `<div class='propmt_cart define_cart'> 이미 장바구니에 포함되어 있습니다. 
                    <br /> 새로 덮여쓸까요? <hr />
                    <div id='prompt_cart_grid'>
                      <div> <a class='prompt_select paste_cart_'> <img id='paste_cart_' class='prompt_cart_img' src='./source/paste_cart_gray.png'/> 덮여쓰기 </a> </div>
                      <div> <a class='prompt_select shopping_' id='keep_going_shopping'> <img id='shopping_' class='prompt_cart_img' src='./source/shopping_gray.png'/> 취소 </a> </div>
                    </div>
                   </div>`
            $('#buy_item_selector_div').append($div);
        }

        cart_prompt_cheat();

        $('.paste_cart_').bind('click', () => {
        let data = { topic_id : id, num : num, type : 'change' };

            $.ajax({
                url : "add_cart.php",
                type : "post",
                data : data,
        
            }).done( (result) => {
                if(result === 'change') {
                    alert('장바구니를 변경했습니다.');
                    $('.define_cart').remove();   

                $('#buy_item_selector_div').append(clear_cart());
                return cart_prompt_cheat();
                }
            })
        });
    })
}

$('.cart_button').bind('click', (event) => {
    let type = $(event.currentTarget)[0].classList[0];
    let id = $(event.currentTarget)[0].classList[3];
    let data = $('.cart_value_' + id);

    if(!$('#cart_' + id)[0].classList.contains('on')) {
        return alert('선택되지 않은 품목은 수정할 수 없습니다.');
    }

    let origin_num = Number(data[0].classList[3].slice(2));
    let num = Number(data[0].classList[3].slice(2));

    if(type === 'cart_button_left') {
        if(num === 999) {
            return alert('더이상 추가할 수 없습니다.');
        }
        num = num + 1;

    } else if(type ==='cart_button_right') {
        if(num === 1) {
            return alert('더이상 뺄 수 없습니다.');
        }
        num = num - 1;

    } else {
        return alert('오류 발생');
    }

    $('.cart_value_' + id).addClass('p_' + String(num));
    $('.cart_value_' + id).removeClass('p_' + String(origin_num));
    $('#cart_item_input_' + id).val(num);

    origin_cart_list();
})

$('.cart_item_input').change( (event) => {
    let num = Number($(event.currentTarget).val());
    let id = $(event.currentTarget)[0].classList[1];
    let origin_num = Number($('.cart_value_' + id)[0].classList[3].slice(2));

    if(!$('#cart_' + id)[0].classList.contains('on')) {
        return alert('선택되지 않은 품목은 수정할 수 없습니다.');
    }

    $('#cart_item_input_' + id).val(origin_num);
    if(isNaN(num)) {
      return alert('숫자만 입력 가능합니다.');

    } else if(num > 999) {
      return alert('최대 999개까지만 구입할 수 있습니다.');

    } else if(num <= 0) {
      return alert('최소 1개 이상 입력해야 합니다.');
    }
    $('#cart_item_input_' + id).val(num);

    $('.cart_value_' + id).addClass('p_' + String(num));
    $('.cart_value_' + id).removeClass('p_' + String(origin_num));
    origin_cart_list();

})

function origin_cart_list() {
    let cart_arr = [];
    let total_price = 0;
    
    for(let i = 0; i < $('.cart_checkbox').length; i++) {
        let id = $('.cart_checkbox')[i].classList[1];

        if($('#cart_' + id)[0].classList.contains('on')) {
            let total = Number($('.cart_value_' + id)[0].classList[2]) * Number($('.cart_value_' + id)[0].classList[3].slice(2))
            $('.cart_total_price_' + id).html(String(total).replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,') + ' 원');

            total_price = total_price + total;
            cart_arr.push(Number(id));
        }
    }
    let c_total_price = String(total_price).replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
    $('.cart_total_html').html(c_total_price)
}
origin_cart_list();

$('.each_remove_button').bind('click', (event) => {
    let id = $(event.currentTarget)[0].classList[1];
    let type = $(event.currentTarget)[0].classList[2];

    if(type === 'cart_each_remove') {
        type = 'cart';
    }
    const data = { topic_id : id, type : type };

    $.ajax({
        url : "remove_like_and_cart.php",
        type : "post",
        data : data,

    }).done( (result) => {
        if(result === 'list_list') {
            alert('찜 리스트에서 제거했습니다.');
        
        } else if(result === 'cart') {
            alert('장바구니에서 제거했습니다.');
        }

        return window.location.reload();
    })
})

$('.check_list').bind('click', (event) => {
    let all_num = $('.all_total_num')[0].classList[1];

    let choice_num = Number($('.choice_result_num')[0].classList[1]);
    $('#all_total_choice')[0].classList.remove('on');
    $('.choice_result_num')[0].classList.remove(String(choice_num));
    
    if(!$(event.currentTarget)[0].classList.contains('on')) {
        $(event.currentTarget)[0].classList.add('on');
        
        choice_num = choice_num + 1;
        
    } else {
        $(event.currentTarget)[0].classList.remove('on');
        
        choice_num = choice_num - 1;
        let check = $('#all_total_choice')[0].classList[0];
        if(check === 'on') {
            $('#all_total_choice')[0].classList.remove('on');
            $('.all_choice').classList.remove('on');
        }
    }
    origin_cart_list()
    
    $('.choice_result_num')[0].classList.add(String(choice_num));
    $('.choice_select_lists').html(choice_num);

    function checkbox_checked(sel) {
        if(Number(all_num) === choice_num) { // 모두 다 체크된 경우
            $('#all_total_choice')[0].classList.add('on');
            $("input:checkbox[id=" + sel +"]").prop("checked", true);
    
            if($('#' + sel)[0].classList[0] === undefined) {
                $('#' + sel)[0].classList.add('on');
            }
    
        } else {
            $("input:checkbox[id=" + sel +"]").prop("checked", false);
        }
    }
    checkbox_checked('all_total_choice');
})

$('.all_choice').bind('click', (event) => {
    let child_check = $('.check_list');
    let choice_num = child_check.length;

    $('.choice_result_num')[0].classList.remove($('.choice_result_num')[0].classList[1]);
    if(!$(event.currentTarget)[0].classList.contains('on')) { // 전체 선택
        $(event.currentTarget)[0].classList.add('on');

        $('.choice_result_num')[0].classList.add(String(choice_num));
        $('.choice_select_lists').html(choice_num);

        toggle(true);

    } else { // 전체 풀기
        $(event.currentTarget)[0].classList.remove('on');

        $('.choice_result_num')[0].classList.remove(String(choice_num));
        $('.choice_result_num')[0].classList.add(String(0));

        $('.choice_select_lists').html(0);

        toggle(false);
    }

    function toggle(boo) {
        for(let i = 0; i < child_check.length; i++) {
            let id = child_check[i].classList[1];
            id = 'lists_check_' + id;

            if(boo) {
                $("input:checkbox[name=" + id +"]").prop("checked", true);
                child_check[i].classList.add('on')

            } else {
                $("input:checkbox[name=" + id +"]").prop("checked", false);
                child_check[i].classList.remove('on')
            }
        }
        origin_cart_list()
    };
})

$('.list_all_remove').bind('click', () => {
    let select = Number($('.choice_result_num')[0].classList[1]);

    if(select === 0) {
        return alert('선택된 상품이 하나도 없습니다.');
    }
    
    let type = $('.list_all_remove')[0].classList[3];
    let check = confirm('정말 삭제하시겠습니까?');

    if(!check) {
        return;
    }

    let child_check = $('.check_list');

    for(let i = 0; i < child_check.length; i++) {
        if(child_check[i].classList.contains('on')) {
            let data = { topic_id : cover = Number(child_check[i].classList[1]), type : type };

            $.ajax({
                url : "remove_like_and_cart.php",
                type : "post",
                data : data,
            }).done( () => {
                return window.location.reload();
            })
        }
    };
});

$('.order_selector').bind('click', (event) => {
    let select = Number($('.choice_result_num')[0].classList[1]);
    if(select === 0) {
        return alert('선택된 상품이 하나도 없습니다.');
    }

    let type = $(event.currentTarget)[0].classList[1];
})

$('.cart_order').bind('click', () => {
    let select = Number($('.choice_result_num')[0].classList[1]);
    if(select === 0) {
        return alert('선택된 상품이 하나도 없습니다.');
    }

    let check = confirm('주문을 진행하시겠습니까?');
    
    if(check) {
        return window.location.replace('./order.php');
    }
})

$('.add_profile_img').bind('click', (event) => {

    let type = $('input[name="user_type"]:checked').val();
    $('#img_change_' + type).click();
})

$('.user_img_change').change( () => {
    let type = $('input[name="user_type"]:checked').val();
    
    let img = null;
    if(type === 'buyer') {
        img = document.all.user_img_input_buyer.value;

    } else {
        img = document.all.user_img_input_seller.value;
    }

    let file = $('.user_img_change_' + type)[0].files[0];
    let id = $('.signup_input_id').val().trim();
    
    var formData = new FormData();
    formData.append('file', file);
    formData.append('boo', 'example');
    formData.append('user_id', id);

    if(img === '') { // 파일을 추가하지 않을 경우
        formData.append('boo', 'remove');
        call_ajax(formData, id);
        return;
    }

    let check = file_check(file, 3000000);
    if(!check) {
        return;
    };

    return call_ajax(formData, id);
})


function call_ajax(formData, id, boo) {
    return $.ajax({
        url : "user_img_update.php?files",
        type : "post",
        data : formData,
        contentType: false,
        processData: false,
        // contentType: 'multipart/form-data',
        // dataType: 'json',
        cache: false,

    }).done( (result) => {
        $('.company_complate_error').remove();
        let type = $('input[name="user_type"]:checked').val();

        if(result === 'true') {
                $('.add_profile_img_' + type).attr({ 'src' : './source/updating.gif'});
                $('.add_profile_img_' + type).addClass('add');

                setTimeout( () => {
                    return $('.add_profile_img_' + type).attr({ 'src' : './source/user_profile_example/' + id + '.png'});
                }, 500);

        } else if(result === 'false') {

            $('.add_profile_img_' + type).removeClass('add');
            $('.add_profile_img_' + type).attr({ 'src' : './source/user_profile.png' });
        }
    })
}

    function phone_number_input() {
        let type = $('input[name="user_type"]:checked').val();

        let phone = {
            middle : $('.signup_middle_phone_' + type).val(),
            last : $('.signup_last_phone_' + type).val(),
        }

        let allow = true;
        let $alert = '';
        $('.sign_complate_error').remove();

        let select = 'phone_first_num_' + type
        let number = String($("select[name=" + select +"]").val() + phone.middle +  phone.last);
        let number_type = Number(number);

        if(number.length !== 11) {
            $alert = `<u class='sign_complate_error b'> * 칸당 4글자씩 채워주세요. </u>`;
            allow = false;
    
        } else if(isNaN(Number(number_type))) {
            $alert = `<u class='sign_complate_error b'> * 숫자만 기입해주세요. </u>`;
            allow = false;
        }

        $('.user_phone_alert_div_' + type).append($alert);
        return allow;
    }

$('.user_phone_number_input').change( (event) => {
    return phone_number_input(event);
})

$('.host_input').change( (event) => {
    return host_check();
})

function host_check() {
    let type = $('input[name="user_type"]:checked').val();

    let first = $('.signup_first_host_' + type).val();
    let second = $('.signup_second_host_' + type).val();  
    $('.host_complate_error').remove();

    let allow = true;
    let $alert = '';
    if(first.length === 0 || second.length === 0) {
        $alert = '<u class="host_complate_error b"> * 빈칸들을 모두 기입해주세요. </u>'
        allow = false;

    } else if(first.includes('/') || second.includes('/')) {
        $alert = '<u class="host_complate_error b"> * (/) 문구는 사용할 수 없습니다. </u>'
        allow = false;
    }

    $('.user_host_alert_div_' + type).append($alert);
    return allow;
}

function check_company_logo() {
    let img = document.all.user_img_input_seller.value;
    $('.company_complate_error').remove();
    
    if(img === '') {
        $alert = '<u class="company_complate_error b"> * 판매 대표 로고는 필수입니다. </u>'
        $('.user_picture_div_seller').append($alert);
        return false;
    }
    return true;
}

$('.signup_complate_button').bind('click', (event) => {
    let type = $('input[name="user_type"]:checked').val();
    
    let nickname = $('.signup_input_nick').val().trim();
    let company = null;
    if(type === 'seller') {
        var logo = check_company_logo();

        if($('#company_name_input').val().trim().length === 0) {
            company = nickname;

        } else {
            company = $('#company_name_input').val().trim();
        }
    }
    
    const host = host_check();
    const phone = phone_number_input();
    
    if(!logo && type === 'seller') {
        return;
    }

    if(host, phone) {
        let file = $('.user_img_change_' + type)[0].files[0];
        let id = $('.signup_input_id').val().trim();    
        let password = $('.signup_input_pass').val().trim();
        let confirm = $('.signup_input_confirm').val().trim();
        
        var formData = new FormData();
        formData.append('user_id', id);
        formData.append('file', file);
        formData.append('boo', 'add');

        call_ajax(formData, id);
        
        let phone = {
            middle : $('.signup_middle_phone_' + type).val(),
            last : $('.signup_last_phone_' + type).val(),
        }
        let first = $('.signup_first_host_' + type).val();
        let second = $('.signup_second_host_' + type).val(); 
        const host = { first : first, second : second };

        let select = 'phone_first_num_' + type
        let phone_val = String($("select[name=" + select +"]").val() + '-' + phone.middle + '-' + phone.last);

        file = id + '.png';
        if(!$('.add_profile_img_' + type)[0].classList.contains('add')) {
            file = null;
        }

        const data = { id : id, nickname : nickname, password : password, confirm : confirm, type : type, host_first : host.first, host_second : host.second, phone : phone_val, file : file, company : company }

        $.ajax({
        url : "signup_updata.php",
        type : "post",
        data : data,
        async : false,
        success : ( (result) => {
            if(result === 'true') {
                alert('회원가입이 완료되었습니다.');

                return window.location.replace('login.php?id=' + id);
            }
        })
    });
    }
})

function order_complate(price, topic_arr, seller_arr) {
    let check = confirm('결제를 진행하시겠습니까?');
    if(check) {
        let payment_type = $('#order_payment_select').val();

        let cover_arr = seller_arr;
        let result_arr = [];

        // 배열안에 2개 이상의 동일한 판매자를 하나씩으로 통일
        cover_arr = cover_arr.forEach( (el, key) => {
            let check = cover_arr[key] !== cover_arr[key + 1]
            if(check) {
                result_arr.push(cover_arr[key]);

            } else if(cover_arr[key + 1] === undefined) {
                result_arr.push(cover_arr[key]);
            } 
        })

        result_arr.forEach( (el) => {
            // 판매자에게 알람 전송
            let seller_alert = { type : 'alert', seller_id : el };
            $.ajax({
                url : "order_complate.php",
                type : "post",
                data : seller_alert,
            })
        });

        let seller_alert = { type : 'search' };
        let count = 0;

        $.ajax({
            url : "order_complate.php",
            type : "post",
            data : seller_alert,
            async : false,
        })
        .done( (result) => {
            let order_id = Number(result) + 1;

            topic_arr.forEach( (el, key) => {
                let cart_delete = { type : 'delete', topic_id : el };
                $.ajax({
                    url : "order_complate.php",
                    type : "post",
                    data : cart_delete,
                    async : false,
                })
                .done( (num) => {
                    let data = { type : 'add', seller_id : seller_arr[key], topic_id : el, price : price, payment_type : payment_type, order_id : order_id, num : num };
                    
                    $.ajax({
                        url : "order_complate.php",
                        type : "post",
                        data : data,
                        async : false,
                    })
                    .done( (result) => {
                        if(result === 'true') {
                            count++;
                        }
                        if(count === topic_arr.length) {
                            alert('상품 구입이 완료되었습니다.');
                            return window.location.replace('index.php');
                        }
                    })
                })
            })
        })

        return;
        // const cart_delete = { price : price, payment_type : payment_type, type : 'delete' };

        // 해당 물품이 들어있는 장바구니 삭제
        topic_arr.forEach( (el) => {
            let cart_delete = { type : 'delete', topic_id : el };
            $.ajax({
                url : "order_complate.php",
                type : "post",
                data : cart_delete,
            })
        })
        ///////////////////////////////////
        

        // topic_arr.forEach( (el) => {
            // order_id 최신 찾기
            // let seller_alert = { price : price, type : 'search', seller_id : el };
            

            $.ajax({
                url : "order_complate.php",
                type : "post",
                data : seller_alert,
                async : false,
            })
            .done( (result) => {
                    console.log(result);
                return
                topic_arr.forEach( (el, key) => {
                    let order_id = Number(result) + 1;

                    let data = { type : 'add', seller_id : seller_arr[key], topic_id : el, price : price, payment_type : payment_type, order_id : order_id };

                    $.ajax({
                        url : "order_complate.php",
                        type : "post",
                        data : data,
                        async : false,
                    })
                    .done( (result) => {
                        if(result === 'true') {
                            count++;
                        }
                        if(count === topic_arr.length) {
                            alert('상품 구입이 완료되었습니다.');
                            return window.location.replace('index.php');
                        }
                    })

                })
            })
        // });

    }
}

$('.phone_input').change( () => {
    const obj = {
        type : 'phone',
        alert : '.alert',
        select : '#change_user_phone',
        first : '.phone_text_1',
        second : '.phone_text_2',
        alert_host : '#user_info_margin',
        alert_name : 'alert',
    }
    order_input_check(obj)
})

$('.host_input_order').change( () => {
    const obj = {
        type : 'host',
        alert : '.host_alert',
        select : '#user_info_host_title',
        first : '.host_test_1',
        second : '.host_test_2',
        alert_host : '#user_info_host_div',
        alert_name : 'alerts',
    }

    order_input_check(obj)
})

function order_input_check(obj) {
    var $alert = '';
    if(obj.type === 'phone') {
        $alert = '* 전화 번호 <b class="b"> (변경) </b>'
    } else {
        $alert = '* 주소 <b class="b"> (변경) </b>'
    }

    $('.' + obj.alert_name).remove();
    $(obj.select).addClass('change');
    $(obj.select).html($alert)

    let first = $(obj.first)[0].value;
    let second = $(obj.second)[0].value;

    var check = true;
    var $alert = '';

    check_num(first);

    if(check) {
        check_num(second);
    }

    function check_num(num) {
        let first_check = $('#user_info_host_title')[0].classList.contains('change');
        let second_check = $('#change_user_phone')[0].classList.contains('change');

        if(first_check || second_check) {
            $('#save_my_info_button a').css({ 'color' : 'black' });
        }

        if(obj.type === 'phone') {
            if(isNaN(Number(num))) {
                $('#save_my_info_button a').css({ 'color' : '#ababab' });
                $alert = '<div class="' + obj.alert_name +' b"> * 숫자만 기입해주세요. </div>'

                $(obj.select).removeClass('change');
                $('#change_user_phone').html('* 전화 번호')

                return check = false;
        
            } else if(num.length !== 4) {
                $('#save_my_info_button a').css({ 'color' : '#ababab' });
                $alert = '<div class="' + obj.alert_name +' b"> * 칸당 4글자씩 채워주세요. </div>';

                $(obj.select).removeClass('change');
                $('#change_user_phone').html('* 전화 번호')

                return check = false;
            }

        } else {
            if(num.length === 0) {
                $('#save_my_info_button a').css({ 'color' : '#ababab' });
                $alert = '<div class="' + obj.alert_name +' b"> * 최소 1글자 이상 입력해주세요. </div>';

                $(obj.select).removeClass('change');
                $('#user_info_host_title').html('* 주소')

                return check = false;
            }
        }
        return check = true;
    }

    if(!check) {
        return $(obj.alert_host).append($alert);
    }
}

function add_save_my_info() {
    let first_check = $('#user_info_host_title')[0].classList.contains('change');
    let second_check = $('#change_user_phone')[0].classList.contains('change');

    if(!first_check && !second_check) {
        return alert('변경된 내용이 하나도 없습니다.');
    }

    const data = {
        first_phone : $('.selec')[0].value,
        middle_phone : $('.phone_text_1')[0].value,
        last_phone : $('.phone_text_2')[0].value,
        first_host : $('.host_test_1')[0].value,
        last_host : $('.host_test_2')[0].value,
    }

    $.ajax({
        url : "add_my_info.php",
        type : "post",
        data : data,
        async : false,

    }).done( (result) => {

        if(result === 'true') {
            let offset = $('.user_save_host').offset();
            $('.user_save_host').animate({ scrollTop : offset.top }, 400);

            alert('새로운 정보를 추가하였습니다.');
            return window.location.reload();

        } else {
            alert('더이상 추가할 수 없습니다.');
            return window.location.reload();
        }
    })

}

function call_my_host_info(host_id) {
    // const data = { host_id : host_id }
        $.ajax({
            url : "get_my_host_list.php?host_id=" + host_id,
            type : "get",

        }).done( (result) => {
            console.log(result);
            // alert('해당 자료를 삭제했습니다.');
            // return window.location.reload();
        })
}

$('.save_my_list').bind('mouseover', (event) => {
    $(event.currentTarget).css({ 'background-color' : '#ebfbee' })

}).bind('mouseleave', (event) => {
    $(event.currentTarget).css({ 'background-color' : 'white' })
})

function remove_each_save_list(host_id) {
    let check = confirm('해당 정보를 정말 삭제하시겠습니까?');

    if(check) {
        const data = { host_id : host_id }
        $.ajax({
            url : "remove_my_save_host.php",
            type : "post",
            data : data,
            async : false,

        }).done( () => {
            alert('해당 자료를 삭제했습니다.');
            return window.location.reload();
        })
    }
}