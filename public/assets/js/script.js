var QuranJS={siteUrl:"",totalAyatSpaces:[""],totalAyat:0,headSurah:0,loadingText:['"Hai orang-orang yang beriman. Bersabarlah kamu, dan kuatkanlah kesabaranmu dan tetaplah bersiaga-siaga (diperbatasan negrimu) dan bertaqwalah kepada Allah supaya kamu beruntung." (Ali-Imran 200).','"Tetapi orang yang bersabar dan memaafkan sesungguhnya (perbuatan) yang demikian itu termasuk hal-hal yang diutamakan" (Asy-Syuura 43)','"Sesengguhnya kesabaran itu hanyalah pada pukulan yang pertama dari bala" (Hadist Muttafaq\'alaih)'],modalLoading:function(){randomInt=Math.floor(2*Math.random())+1,$(".modal-title").html('<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>'),$(".modal-body").html(this.loadingText[randomInt]),$(".modal-header button").hide()},modalLoadingBlock:function(){},removeModalClass:function(){$("#QuranModal").removeClass("login-mode"),$("#QuranModal").removeClass("register-mode"),$("#QuranModal").removeClass("share-mode"),$("#QuranModal").removeClass("content-mode")},changePage:function(a){page=$(a).data("value"),"undefined"==typeof page&&(page=$("."+a).val()),""!=page&&($("#preloader").css("height","2000px"),$("#preloader").show(),location.href=this.siteUrl+"/mushaf/page/"+page)},changeSurah:function(a){location.href=this.siteUrl+"/mushaf/surah/"+$(a).val()},fillAyatEnd:function(a){jQuery("#fill_ayat_end").is(":checked")?$(".ayat_end").show():$(".ayat_end").hide()},callModal:function(a){$("#QuranModal").modal("show"),this.modalLoading(),this.removeModalClass(),$.getJSON(this.siteUrl+"/"+a,{},function(a){$(".modal-title").html(a.modal_title),$(".modal-body").html(a.modal_body),""!=a.modal_footer&&($(".modal-footer").show(),$(".modal-footer").html(a.modal_footer)),$("#QuranModal").addClass(a.modal_class),$(".modal-header button").show()})},createMemoz:function(a){this.modalLoading(),$.getJSON(this.siteUrl+"/"+a,{},function(a){$(".modal-title").html(a.modal_title),$(".modal-body").html(a.modal_body),$(".modal-footer").html(a.modal_footer),$(".modal-header button").show()})},showRegister:function(){this.removeModalClass(),$(".modal-title").html("Daftar"),$(".login_form").hide(),$(".register_form").show(),$("#QuranModal").addClass("register-mode")},registerProcess:function(){this.modalLoadingBlock(),name=$("#name").val(),email=$("#email").val(),password=$("#password").val(),$.post(this.siteUrl+"/auth/registerProcess",{name:name,email:email,password:password},function(a){console.log(a)})},showLogin:function(){this.removeModalClass(),$(".modal-title").html("Masuk Dahulu"),$(".login_form").show(),$(".register_form").hide(),$("#QuranModal").addClass("login-mode")},generateTransHeight:function(a){$(".trans").each(function(a,e){className="."+$(e).attr("class").split(" ").join("."),height=$(className).outerHeight(),$(className).attr("style","height:"+height+"px")})},generateArHeight:function(a){$(".arabic").each(function(a,e){className="."+$(e).attr("class").split(" ").join("."),height=$(className).outerHeight(),$(className).attr("style","height:"+height+"px")})},redHightlight:function(){$(".trans").highlight("Allah","highlight-red",{wordsOnly:!0}),$(".arabic").highlight("للَّهِ","highlight-red"),$(".arabic").highlight("ٱللَّهُ","highlight-red"),$(".arabic").highlight("ٱللَّهَ","highlight-red"),$(".arabic").highlight("لِلَّهِ","highlight-red")},memorized:function(a){$("."+a).addClass("memorized"),$("."+a+" .action-footer").remove()},showMushafAction:function(a){$(".footer_action").val(a),"true"==a?$(".action-footer").show():$(".action-footer").hide(),document.cookie="coo_footer_action="+a+";"},showMushaf:function(a){jQuery(".mushaf").removeClass("mushaf_arabic_trans"),jQuery(".mushaf").removeClass("mushaf_arabic"),jQuery(".mushaf").removeClass("mushaf_trans"),"mushaf_arabic_trans"==a?(jQuery(".trans").show(),jQuery(".arabic").show()):"mushaf_arabic"==a?(jQuery(".arabic").show(),jQuery(".trans").hide()):"mushaf_trans"==a&&(jQuery(".trans").show(),jQuery(".arabic").hide()),jQuery(".mushaf_layout").val(a),jQuery(".mushaf").addClass(a),jQuery(".mushaf_display a").removeClass("active"),jQuery("."+a).addClass("active"),document.cookie="coo_mushaf_layout="+a+";"},autoPlay:function(a){$(".automated_play").val(a),document.cookie="coo_automated_play="+a+";"},showInfoMemoz:function(){$("#QuranModal").modal("show"),$(".modal-title").html("Panduan menghafal"),$(".modal-body").html("<p>Dalam proses hafalan terdapat 5 tahapan, yaitu: </p><br><ul><li> Hafalkan dengan teliti target hafalan arabic dan terjemahannya, ulangi muratal sebanyak-banyaknya sampai hafal</li><li>Hafalkan dengan teliti target hafalan arabic</li><li>Fokuskan hafalan terjemahannya saja</li><li>TEST...!! Bacakan setiap kata yang di hilangkan.</li><li>PUZZLE...!! Cocokan kata yang hilang secara berurutan</li></ul><br><p>Jangan lupa untuk berdo'a kepada Allah Ta'ala untuk di mudahkan dalam penghafalan dan pemahaman terhadap target hafalan antum.</p><p>Kunci untuk mengafal adalah <strong>ulangi dan terus ulangi</strong> membaca dan mendengarkan muratal."),$(".modal-footer").html('<span class="cont_hide_memoz_info"> <input type="checkbox" name="hide_memoz_info" onclick="hideInfo()" value="1"> Jangan tampilkan lagi <br></span><button  data-dismiss="modal" class="btn btn-green-small info">Bismillah mulai menghafal</button></div>')},stepMemoz:function(e){if(jQuery(".ayat_arabic_memoz").removeClass("blur-ayat"),1==e)jQuery(".steps_desc p").html('<i class="fa fa-info-circle"></i> Hafalkan dengan teliti target hafalan arabic dan terjemahannya, ulangi muratal sebanyak-banyaknya sampai hafal'),jQuery(".jp-stop").click(),jQuery(".memozed,.memoz_nav").hide(),jQuery("*",".mushaf").removeClass("playing"),jQuery(".puzzle").hide(),jQuery(".ayat_arabic_memoz").removeClass("puzzle_q"),jQuery(".ayat_arabic_memoz").removeClass("active"),jQuery(".content_ayat .puzzle_border").addClass("puzzle_no_border"),jQuery(".trans").show(),jQuery(".arabic").show();else if(2==e)jQuery(".steps_desc p").html('<i class="fa fa-info-circle"></i> Hafalkan dengan teliti target hafalan arabic'),jQuery(".jp-stop").click(),jQuery(".memozed,.memoz_nav").hide(),jQuery("*",".mushaf").removeClass("playing"),jQuery(".puzzle").hide(),jQuery(".ayat_arabic_memoz").removeClass("puzzle_q"),jQuery(".ayat_arabic_memoz").removeClass("active"),jQuery(".content_ayat .puzzle_border").addClass("puzzle_no_border"),jQuery(".trans").hide(),jQuery(".arabic").show();else if(3==e)jQuery(".steps_desc p").html('<i class="fa fa-info-circle"></i> Fokuskan hafalan terjemahannya saja'),jQuery(".jp-stop").click(),jQuery(".memoz_nav").hide(),jQuery(".puzzle").hide(),jQuery(".ayat_arabic_memoz").removeClass("puzzle_q"),jQuery(".ayat_arabic_memoz").removeClass("active"),jQuery(".content_ayat .puzzle_border").addClass("puzzle_no_border"),jQuery(".trans").show(),jQuery(".arabic").hide();else if(4==e)jQuery(".steps_desc p").html('<i class="fa fa-info-circle"></i> TEST...!! Bacakan setiap kata yang di hilangkan.'),jQuery(".jp-stop").click(),jQuery(".memoz_player,.memozed").show(),jQuery(".memoz_nav").show(),jQuery("*",".mushaf").removeClass("playing"),jQuery(".puzzle").hide(),jQuery(".ayat_arabic_memoz").removeClass("puzzle_q"),jQuery(".ayat_arabic_memoz").removeClass("active"),jQuery(".content_ayat .puzzle_border").addClass("puzzle_no_border"),jQuery(".trans").show(),jQuery(".arabic").show();else if(5==e){for(jQuery(".steps_desc p").html('<i class="fa fa-info-circle"></i> PUZZLE...!! Cocokan kata yang hilang secara berurutan'),jQuery(".jp-stop").click(),jQuery(".memoz_player,.memozed,.puzzle").show(),jQuery(".memoz_nav").hide(),jQuery(".ayat_arabic_memoz").addClass("puzzle_q"),jQuery("*",".mushaf").removeClass("playing"),$(".puzzle"+Math.ceil(2*Math.random())).show(),jQuery(".trans").hide(),jQuery(".arabic").show(),a=0;a<=this.totalAyat;a++)for(var t=jQuery(".puzzle.puzzle_"+a+" .content_ayat"),o=t.children();o.length;)t.append(o.splice(Math.floor(Math.random()*o.length),1)[0]);var r=jQuery("#puzzle_word").val();""==r&&(jQuery("#puzzle_ayat").val(this.headSurah),jQuery("#puzzle_word").val("1"),jQuery(".arabic_"+this.headSurah+" .content_ayat .puzzle_border").first().removeClass("puzzle_no_border"))}jQuery(".steps a").removeClass("selected"),jQuery(".steps_"+e).addClass("selected")},puzzleAnswer:function(a){var e=jQuery("#puzzle_ayat").val(),t=jQuery("#puzzle_word").val(),o=".arabic_"+e+" .per_words_"+t,r=jQuery(a).data("css");e=parseInt(e),t=parseInt(t),o==r?(jQuery(o).css("visibility","visible"),jQuery(o).parent().addClass("puzzle_no_border"),jQuery(o).parent().next().removeClass("puzzle_no_border"),jQuery(o).parent().next().removeClass("puzzle_no_border"),o=jQuery(o).parent().next().children().data("css"),jQuery("#puzzle_active").val(o),jQuery(a).remove(),t+=1,jQuery("#puzzle_word").val(t),console.log(jQuery(".puzzle_"+e+" .arabic-puzzle a").length),0==jQuery(".puzzle_"+e+" .arabic-puzzle a").length&&(jQuery(".puzzle_"+e).remove(),e+=1,jQuery("#puzzle_ayat").val(e),jQuery("#puzzle_word").val("1"),console.log(".arabic_"+e+" .per_words_1"),jQuery(".arabic_"+e+" .per_words_1").parent().removeClass("puzzle_no_border"))):alert("salah")},showAyat:function(e){for(jQuery(".ayat_arabic_memoz").removeClass("blur-ayat"),jQuery(".memoz_nav .btn").removeClass("active"),a=1,jQuery(".btn-"+e).addClass("active"),o=0;o<=this.totalAyatSpaces.length;o++)if("start"==e)for(min=this.totalAyatSpaces[o]>=10?3:2,b=min;b<=this.totalAyatSpaces[o];b++)jQuery(".arabic_"+o+" .per_words_"+b).addClass("blur-ayat");else if("end"==e)for(max=this.totalAyatSpaces[o]>=10?this.totalAyatSpaces[o]-1:this.totalAyatSpaces[o],console.log(max),b=1;b<=this.totalAyatSpaces[o];b++)b<max&&jQuery(".arabic_"+o+" .per_words_"+b).addClass("blur-ayat");else if("mix"==e)for(min=this.totalAyatSpaces[o]>=10?3:2,max=this.totalAyatSpaces[o]>=10?this.totalAyatSpaces[o]-1:this.totalAyatSpaces[o],b=min;b<=this.totalAyatSpaces[o];b++)b<max&&jQuery(".arabic_"+o+" .per_words_"+b).addClass("blur-ayat");else if("middle"==e)for(min=this.totalAyatSpaces[o]>=10?4:2,max=this.totalAyatSpaces[o]>=10?this.totalAyatSpaces[o]-3:this.totalAyatSpaces[o],b=1;b<=this.totalAyatSpaces[o];b++)b<=min&&jQuery(".arabic_"+o+" .per_words_"+b).addClass("blur-ayat"),b>=max&&jQuery(".arabic_"+o+" .per_words_"+b).addClass("blur-ayat");else if("random"==e)for(b=1;b<=this.totalAyatSpaces[o];b++)b%2==0&&jQuery(".arabic_"+o+" .per_words_"+b).addClass("blur-ayat")},showSearch:function(){$("#QuranModal").modal("show"),$(".modal-title").html("Pencarian"),htmlSearchSurah=jQuery(".select-surah").html(),$(".modal-body").html(htmlSearchSurah),$(".modal-footer").html('<button class="btn btn-green-small" data-dismiss="modal">Tutup</button>')},createMemoModal:function(){$("#QuranModal").modal("show"),$(".modal-title").html("Hafalan Baru"),htmlSearchSurah=jQuery(".select-surah").html(),$(".modal-body").html(htmlSearchSurah),$(".modal-footer").html('<button class="btn btn-green-small" data-dismiss="modal">Tutup</button>')},setBookmark:function(a,e){var t=jQuery("#bookmark").hasClass("fa-bookmark-o");1==t?(document.cookie="coo_mushaf_bookmark_title="+a+";visited=true;path=/;",document.cookie="coo_mushaf_bookmark_url="+e+";visited=true;path=/;",jQuery("#bookmark").removeClass("fa-bookmark-o"),jQuery("#bookmark").addClass("fa-bookmark"),alert(a+" - telah di tandai halaman terakhir dibaca")):(document.cookie="coo_mushaf_bookmark_title=;visited=true;path=/;",document.cookie="coo_mushaf_bookmark_url=;visited=true;path=/;",jQuery("#bookmark").removeClass("fa-bookmark"),jQuery("#bookmark").addClass("fa-bookmark-o"),alert("Halaman terakhir dibaca dihapus"))},bookmarkModal:function(a,e){var t=this.siteUrl+"/mushaf/page/1";if(""==a)return location.href=t,!1;var o='<div class="center">';o+="<h4>Lanjut baca "+a+"<h4>",o+='<button class="btn btn-green-small" onclick="location.href=\''+e+"'\">Ya</button> ",o+='<button class="btn btn-green-small"  onclick="location.href=\''+t+"'\">Tidak</button>",o+="</div>",$(".modal-title").html("Halaman terakhir dibaca"),$(".modal-body").html(o),$(".modal-footer").show(),$(".modal-footer").html('<button class="btn btn-green-small" data-dismiss="modal">Tutup</button>'),$(".modal-header button").show(),$("#QuranModal").modal("show")}};