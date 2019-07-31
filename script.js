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


    //////////////////////////////////////////////////////////////
    // 장바구니 //////////////////////////////////////////////////

    // if($('.cart_checkbox').length !== 0 && location.href.includes('cart.php')) {
    //     // 최소 1개 이상의 장바구니가 있고, 현재 위치가 cart.php에 있으면 실행

    //     // for(let i = 0; i < $('.cart_checkbox').length; i++) {
    //     //     let topic_id = $('.cart_checkbox')[i].classList[1];
    //     //     $("input:checkbox[name=cart_c_" + topic_id +"]").prop("checked", true);

    //     // }


    // }
    ///////////////////////////////////////////////////////////////
});


$('#signup_button').bind('click', () => {
    let id = document.getElementById('signup_id').value.trim();
    let nickname = document.getElementById('signup_nick').value.trim();
    let password = document.getElementById('signup_pass').value.trim();
    let confirm = document.getElementById('signup_confirm').value.trim();

    let type;
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

            if(str_array[key] === 'id' || str_array[key] === 'nickname') {
            function check_id_nick(el) {
                let posi = str_array[key];
                if(str_array[key] === 'id') {
                    posi = 'user_id';
                }

                const data = { data : el, position : posi };
                var res = false;
                
                $.ajax({
                    url : "signup_check.php",
                    type : "post",
                    data : data,
                    async : false,
                    success : ( (result) => {
                        if(result === '0') {
                            res = true;
                            return res;
                        }
                    })
                });
                return res;
            }
            id_check = check_id_nick(id);
            nick_check = check_id_nick(nickname);

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
        }

            if(str_array[key] === 'confirm') {
                if(password !== confirm) {
                    allow = false;
                    $alert = `<div class='signup_alert b' id='alert_${str_array[key]}'> * 비밀번호가 일치하지 않습니다. </div>`;
                    return $('#signup_' + str_array[key] +'_div').append($alert);
                }
            }
        }
    })

    if(allow) {
    const data = { id : id, nickname : nickname, password : password, type : type };

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

$('#login_button').bind('click', () => {
    let id = document.getElementById('login_id').value.trim();
    let password = document.getElementById('login_pass').value.trim();

    $('.login_fail_alert').remove();

    let allow = true;
    let $alert = '';

    let str_array = ['id', 'password'];
    let val_array = [id, password];

    str_array.forEach( (el, key) => {
        if(val_array[key].length === 0) {
            $('#alert_' + el).remove();
            allow = false;

            $alert = `<div class='login_alert b' id='alert_${el}'> * 최소 1글자 이상, 10글자 이하로 입력해야 합니다. </div>`;
            $('#login_' + el + '_div').append($alert);
        }
    })
    
    $('.login_input').bind('click', (event) => {
        let val = $(event.currentTarget)[0].classList[1];
        $('#' + val).remove();
    })

    if(allow) {

        const data = { id : id, password : password };

        $.ajax({
            url : "login_check.php",
            type : "post",
            data : data,
            async : false,
            success : ( (result) => {

                if(result === 'false') {
                    $alert = `<div class='login_fail_alert b' id='alert_fail'> * 아이디 및 비밀번호를 다시 확인하십시오. </div>`;
                    return $('.login_tool').append($alert);
                }

                alert('반갑습니다, ' + id + '님!');
                return window.history.back();
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
                const check = ['IMAGE/JPG', 'IMAGE/JPEG', 'IMAGE/PNG', 'IMAGE/GIF'];
                if(!check.includes(file.type.toUpperCase())) {
                    $('html').animate({scrollTop : offset.top}, 400);
                    return alert('이미지 확장자 (jpg(e), png, gif)만 가능합니다.');
        
                } else if(file.size > 1000000) {
                    $('html').animate({scrollTop : offset.top}, 400);
                    return alert('1MB 미만의 크기의 파일만 가능합니다.');
                }
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