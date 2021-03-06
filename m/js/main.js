$( document ).ready( function () {
    
    (function () {
        var kindlist = $( '#kindlist' )
        ,   timelist = $( '#timelist' )
        ,   contentlist = $( '#contentlist' )
        ,   searchInput = $( '#searchInput' )
        ,   noticekindBtn = $( '.noticekind-btn' )
        ,   release = $( '#release' )
        ,   releaSeclistBtn = $( '.relea-seclist-btn' )
        ,   releaSeclist = $( '.relea-seclist' )
        ,   inputKind = $( '#input-kind' )
        ,   inputType = $( '#input-type' )
        ,   tellyou = '请认真点好嘛！！！'
        ,   type = 'losts'   //搜索类别：losts, founds, 用于url拼接
        ,   page = 1
        ,   url = 'http://swzl.ecjtu.net/api.php/losts/1'
        ,   searchType = 'normal';   //搜索模式:normal, key, category, time, 用于加载更多时判断
        
        //toggle show
        var togShow = function ( obj ) {
            var disp = obj.css( 'display' );
            if ( disp === 'none' ) {
                obj.fadeIn( 150 );
            } else {
                obj.fadeOut( 100 );
            }
        }; 
        //Date handle
        var dateHandle = function ( days ) {
            var time = new Date();
            time.setDate( time.getDate() - days + 1 );
            var year  = time.getFullYear()
            ,   month = time.getMonth() + 1
            ,   date  = time.getDate();
            var after = year + '-' + month + '-' + date;
            return after;
        };
        //Ajax
        var show = function ( urlnew ) {
            var url = urlnew ||'http://swzl.ecjtu.net/api.php/losts/1';
            $.get( url, function ( data, status ) {
                if ( data.count ) {
                    var count = data.count
                    ,   list  = data.list
                    ,   i = 0;
                    var box = $( '#contentlist > ul' );
                    var template = $( '#template' ).html();
                    for ( ; ++i < count; ) {
                        var unix = list[ i ][ 'time' ];
                        var time = new Date( unix*1000 );
                        var year  = time.getFullYear()
                        ,   month = time.getMonth() + 1
                        ,   date  = time.getDate();
                        list[ i ][ 'time' ] = year + '-' + month + '-' + date;
                        list[ i ].type = list.type === 'found' ?
                            '招领启事' : '寻物启事';
                        var content = Mustache.to_html( template, list[ i ] );
                        box.append( content );
                    }
                } else {
                    $( '#load' ).text( '没有找到诶' );
                }
            }, 'json' );

        };
        show();
        
        //搜索启事切换
        noticekindBtn.click( function () {
            var classname = $( this ).attr( 'class' );
            if ( classname.search( /active/ ) === -1 ) {
                $( this ).siblings( '.active' ).removeClass( 'active' )
                .end()
                    .addClass( 'active' );
                type = $( this ).data( 'id' );
            }
            page = 1;
            searchType = 'normal';
            url = 'http://swzl.ecjtu.net/api.php/' + type + '/1';
            contentlist.find( 'ul' ).html( '' );
            show( url );
        } );
        
        //搜索框聚失焦
        var initval = '搜索您丢失或捡到的物品';
        searchInput.focus( function () {
            if ( $( this ).val() === initval) {
                $( this ).val( '' );
            }
        } );
        searchInput.blur( function () {
            if ( $( this ).val() === '' ) {
                $( this ).val( initval );
            }
        } );
        //搜索按钮请求
        $( '#searchBtnBox' ).click( function () {
            var value = $( this ).prev().val();
            if ( value !== '搜索您丢失或捡到的物品' || value ) {
                page = 1;
                searchType = 'key';
                url = 'http://swzl.ecjtu.net/api.php/' + type.slice(0, type.length-1)
                    + '?key=' + $( this ).prev().val();
                contentlist.find( 'ul' ).html( '' );
                show( url);
            } 
        } );
        
        //分类查询按钮事件
        kindlist.add( timelist ).click( function () {
            var ul = $( this ).find( 'ul' );
            togShow( ul );
        });
        //分类查询选项事件
        //类别
        kindlist.find( 'ul li' ).click( function () {
            $( this ).siblings( '.sec-ac' )
                .removeClass( 'sec-ac' )
            .end()
                .addClass( 'sec-ac' );
            page = 1;
            searchType = $( this ).parent().data( 'type' );
            url = 'http://swzl.ecjtu.net/api.php/' +
                type.slice(0, type.length-1) + '?' +
                searchType + '=' +
                $( this ).data( 'id' );
            contentlist.find( 'ul' ).html( '' );
            show( url );
        } );
        //时间
        timelist.find( 'ul li' ).click( function () {
            $( this ).siblings( '.sec-ac' )
                .removeClass( 'sec-ac' )
            .end()
                .addClass( 'sec-ac' );
            page = 1;
            searchType = $( this ).parent().data( 'type' );
            url = 'http://swzl.ecjtu.net/api.php/' +
                type.slice(0, type.length-1) + '?' +
                searchType + '=' + dateHandle( $(this).data( 'days' ) * 1 );
            contentlist.find( 'ul' ).html( '' );
            show( url );
        } );
        
        //发布按钮事件
        release.click( function () {
            var releaseshow = $( '#releaseshow' );
            togShow( releaseshow );
        } );
        //发布框二级列表下拉按钮事件
        releaSeclistBtn.click( function ( event )  {
            var releaSeclist = $( this ).siblings( '.relea-seclist' );
            togShow( releaSeclist );
            event.preventDefault();
        } );
        //发布框二级列表选项点击
        releaSeclist.find( 'li' ).click( function () {
            if( !$( this ).is('li.relea-active') ) {
                var value = $( this ).text();
                $( this ).siblings( '.relea-active' )
                    .removeClass( 'relea-active' )
                .end().addClass( 'relea-active' )
                    .parent().siblings( 'input' )
                        .val( value )
                    .end()
                        .hide();
            }
        } );
        //发布框input失焦
        $( '#releaseshow' ).find( 'input.need' ).blur( function () {
            var value = $( this ).val();
            if ( !value ) {
                $( this ).val( tellyou );
            }
        } );
        //发布框input聚焦
        $( '#releaseshow' ).find( 'input.need' ).focus( function () {
            var value = $( this ).val();
            if ( value === tellyou ) {
                $( this ).val( '' );
            }
        } );
        //发布框二级列表input聚焦
        inputKind.add( inputType ).focus( function () {
            var releaSeclist = $(this).siblings( '.relea-seclist' );
            togShow( releaSeclist );
            $( this ).blur();
        } );
        //确认发布按钮事件
        $( '#releasebtn' ).click( function ( event ) {
            var inputNeed =  $( this ).parent().prev().find( '.need' )
            ,   temp = true;
            inputNeed.each( function ( key ) {
                var value = $( this ).val();
                if ( !value || value === tellyou ) {
                    $( this ).val( tellyou );
                    temp = false;
                }
            } );
            if ( !temp ) {
                event.preventDefault();
            } else {
               var formType = inputKind.val() === '招领启事' ? 'found' : 'lost'
                $( 'form' ).attr( 'action', 'http://swzl.ecjtu.net/' + formType );
                window.location.reload();
            }
        } );
        //返回发布按钮事件
        $('#backbtn').click( function () {
            $( '#releaseshow' ).hide();
            event.preventDefault();
        } );
        //更多加载按钮
        $( '#load' ).click( function () {
            page += 1;
            if ( searchType === 'normal' ) {
                url = 'http://swzl.ecjtu.net/api.php/' + type + '/' + page;
            } else {
                url = page !== 2 ? url.slice(0, url.indexOf('&') ) 
                    + '&page=' + page : 
                    url += '&page=' + page;
            }
            show( url );
        } );
        
        //Dom重画部分
        //联系按钮事件
        contentlist.on( 'click', '.tel', function () {
            $( this ).parent().parent().next().show();
        });
        
        //联系人弹出框消失
        contentlist.on( 'click', '.close', function () {
            $( this ).parent().hide();
        });
    })();

});