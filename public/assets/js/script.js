var QuranJS = {
    siteUrl: "",
    totalAyatSpaces: [""],
    totalAyat: 0,
    headSurah: 0,
    loadingText: ['<div class="dzikir-loading">Sambil nunggu baca dzikir yuk : <div class="dzikir">Subhanallah...</div></div>', '<div class="dzikir-loading">Sambil nunggu baca dzikir yuk : <div class="dzikir">Alhamdulillah...</div></div>', '<div class="dzikir-loading">Sambil nunggu baca dzikir yuk : <div class="dzikir">Allahuakbar...</div></div>', '<div class="dzikir-loading">Sambil nunggu baca dzikir yuk : <div class="dzikir">Lailahaillalah...</div></div>'],
    modalLoading: function() {
        randomInt = Math.floor(2 * Math.random()) + 1, $(".modal-title").html('<img src="'+this.siteUrl+'/assets/images/loading.svg" alt="loading" width="50">'), $(".modal-body").html(this.loadingText[randomInt]), $(".modal-header button,.modal-footer").hide()
    },
    modalLoadingBlock: function() {
        $(".modal-body").html("loading")
    },
    removeModalClass: function() {
        $("#QuranModal").removeClass("login-mode"), $("#QuranModal").removeClass("register-mode"), $("#QuranModal").removeClass("share-mode"), $("#QuranModal").removeClass("content-mode")
    },
    changePage: function(a) {
        page = $(a).data("value"), "undefined" == typeof page && (page = $("." + a).val()), "" != page && ($("#preloader").css("height", "2000px"), $("#preloader").show(), location.href = this.siteUrl + "/mushaf/page/" + page)
    },
    changeSurah: function(a) {
        location.href = this.siteUrl + "/mushaf/surah/" + $(a).val()
    },
    fillAyatEnd: function(a) {
        jQuery("#fill_ayat_end").is(":checked") ? $(".ayat_end").show() : $(".ayat_end").hide()
    },
    callModal: function(a) {
        $("#QuranModal").modal("show"), this.modalLoading(), this.removeModalClass(), $.getJSON(this.siteUrl + "/" + a, {}, function(a) {
            $(".modal-title").html(a.modal_title), $(".modal-body").html(a.modal_body), "" != a.modal_footer && ($(".modal-footer").show(), $(".modal-footer").html(a.modal_footer)), $("#QuranModal").addClass(a.modal_class), $(".modal-header button").show()
        })
    },
    createMemoz: function(a) {
        this.modalLoading(), $.getJSON(this.siteUrl + "/" + a, {}, function(a) {
            $(".modal-title").html(a.modal_title), $(".modal-body").html(a.modal_body), $(".modal-footer").html(a.modal_footer), $(".modal-header button").show()
        })
    },
    showRegister: function() {
        this.removeModalClass(), $.getJSON(this.siteUrl + "/register", {}, function(a) {
            $(".modal-title").html(a.modal_title), $(".modal-body").html(a.modal_body), $(".modal-footer").html(a.modal_footer), $(".modal-header button").show(), clientId = jQuery("#clientId_tmp").val(), jQuery("#register_device_id").val(clientId)
        })
    },
    registerProcess: function() {
        this.modalLoadingBlock(), name = $("#name").val(), email = $("#email").val(), password = $("#password").val(), $.post(this.siteUrl + "/auth/registerProcess", {
            name: name,
            email: email,
            password: password
        }, function(a) {
            console.log(a)
        })
    },
    showLogin: function() {
        this.removeModalClass(), $(".modal-title").html("Masuk Dahulu"), $(".login_form").show(), $(".register_form").hide(), $("#QuranModal").addClass("login-mode")
    },
    generateTransHeight: function(a) {
        $(".trans").each(function(a, e) {
            className = "." + $(e).attr("class").split(" ").join("."), height = $(className).outerHeight(), $(className).attr("style", "height:" + height + "px")
        })
    },
    generateArHeight: function(a) {
        $(".arabic").each(function(a, e) {
            className = "." + $(e).attr("class").split(" ").join("."), height = $(className).outerHeight(), $(className).attr("style", "height:" + height + "px")
        })
    },
    redHightlight: function() {
        jQuery(".trans").highlight("Allah", "highlight-red", {
            wordsOnly: !0
        }), jQuery(".arabic").highlight("للَّهِ", "highlight-red"), jQuery(".arabic").highlight("ٱللَّهُ", "highlight-red"), jQuery(".arabic").highlight("ٱللَّهَ", "highlight-red"), jQuery(".arabic").highlight("لِلَّهِ", "highlight-red"), jQuery(".arabic").highlight("اللَّهُ", "highlight-red"), jQuery(".arabic").highlight("اللَّهَ", "highlight-red"), $(".arabic").highlight("ۛ", "highlight-red pause-marks"), $(".arabic").highlight("ۘ", "highlight-red"), $(".arabic").highlight("ۗ", "highlight-red pause-marks"), $(".arabic").highlight("ۚ", "highlight-red pause-marks"), $(".arabic").highlight("ۖ", "highlight-orange"), $(".arabic").highlight("ۙ", "highlight-green pause-marks")
    },
    tajwidHighlight: function() {
        var a = ["ت", "د", "ذ", "ز", "ث", "ج", "س", "ش", "ص", "ض", "ط", "ظ", "ف", "ق", "ك"];
        for (i = 0; i < a.length; i++) jQuery(".arabic").highlight("نْ" + a[i], "highlight-orange tajwid"), $(".arabic").highlight("نْ " + a[i], "highlight-orange tajwid"), $(".arabic").highlight("ً " + a[i], "highlight-orange tajwid tanwin1"), $(".arabic").highlight("ً" + a[i], "highlight-orange tajwid tanwin1"), $(".arabic").highlight("ٌ " + a[i], "highlight-orange tajwid tanwin1"), $(".arabic").highlight("ٌ" + a[i], "highlight-orange tajwid tanwin1"), $(".arabic").highlight("ٍ " + a[i], "highlight-orange tajwid tanwin2"), $(".arabic").highlight("ٍ" + a[i], "highlight-orange tajwid tanwin2");
        var e = ["ي", "ن", "م", "و", "ل", "ر"];
        for (i = 0; i < e.length; i++) $(".arabic").highlight("نْ" + e[i], "highlight-blue tajwid"), $(".arabic").highlight("نْ " + e[i], "highlight-blue tajwid"), $(".arabic").highlight("ً " + e[i], "highlight-blue tajwid tanwin1"), $(".arabic").highlight("ً" + e[i], "highlight-blue tajwid tanwin1"), $(".arabic").highlight("ٌ " + e[i], "highlight-blue tajwid tanwin1"), $(".arabic").highlight("ٌ" + e[i], "highlight-blue tajwid tanwin1"), $(".arabic").highlight("ٍ " + e[i], "highlight-blue tajwid tanwin2"), $(".arabic").highlight("ٍ" + e[i], "highlight-blue tajwid tanwin2");
        var t = ["ب"];
        for (i = 0; i < t.length; i++) $(".arabic").highlight("نْ" + t[i], "highlight-green tajwid"), $(".arabic").highlight("نْ " + t[i], "highlight-green tajwid"), $(".arabic").highlight("ً " + t[i], "highlight-green tajwid tanwin1"), $(".arabic").highlight("ً" + t[i], "highlight-green tajwid tanwin1"), $(".arabic").highlight("ٌ " + t[i], "highlight-green tajwid tanwin1"), $(".arabic").highlight("ٌ" + t[i], "highlight-green tajwid tanwin1"), $(".arabic").highlight("ٍ " + t[i], "highlight-green tajwid tanwin2"), $(".arabic").highlight("ٍ" + t[i], "highlight-green tajwid tanwin2");
        $.fn.nthEverything(), $(".tajwid").each(function(a) {
            $(this).html("&zwj;" + $(this).html() + "&zwj;")
        }), $(".tajwid").val("true")
    },
    memorized: function(a) {
        $("." + a).addClass("memorized"), $("." + a + " .action-footer").remove()
    },
    showMushafAction: function(a) {
        $(".footer_action").val(a), "true" == a ? $(".action-footer").show() : $(".action-footer").hide(), document.cookie = "coo_footer_action=" + a + ";visited=true;path=/;"
    },
    configMuratal: function(a, e) {
        return "Al_Afasy" == a ? (this.refreshMuratal(a), !0) : "Ali_Jaber" == a || "As_Sudais" == a || "Ghamadi" == a || "Husary" == a || "Menshawi" == a ? e < 1 ? (this.callModal("subscription"), !0) : (this.refreshMuratal(a), !0) : "Warsh_AlDosary" != a && "Warsh_AbdulBasit" != a && "Warsh_Yassin_AlJazaery" != a || (e < 2 ? (this.callModal("subscription"), !0) : (this.refreshMuratal(a), !0))
    },
    refreshMuratal: function(a) {
        $(".muratal").val(a), document.cookie = "coo_sound=" + a + ";visited=true;path=/;", $(".muratal_modified").show()
    },
    showMushaf: function(a) {
        jQuery(".mushaf").removeClass("mushaf_arabic_trans"), jQuery(".mushaf").removeClass("mushaf_arabic"), jQuery(".mushaf").removeClass("mushaf_trans"), "mushaf_arabic_trans" == a ? (jQuery(".trans").show(), jQuery(".arabic").show()) : "mushaf_arabic" == a ? (jQuery(".arabic").show(), jQuery(".trans").hide()) : "mushaf_trans" == a && (jQuery(".trans").show(), jQuery(".arabic").hide()), jQuery(".mushaf_layout").val(a), jQuery(".mushaf").addClass(a), jQuery(".mushaf_display a").removeClass("active"), jQuery("." + a).addClass("active"), document.cookie = "coo_mushaf_layout=" + a + ";visited=true;path=/;"
    },
    showTajwid: function(a) {
        document.cookie = "true" == a ? "coo_tajwid=" + a + ";visited=true;path=/;" : "coo_tajwid=;visited=true;path=/;", $(".tajwid_modified").show()
    },
    autoPlay: function(a) {
        $(".automated_play").val(a), document.cookie = "coo_automated_play=" + a + ";visited=true;path=/;"
    },
    memozList: function() {
        $("#QuranModal").modal("show"), this.modalLoading(), this.removeModalClass(), $.getJSON(this.siteUrl + "/memoz/list", {}, function(a) {
            $(".modal-title").html(a.modal_title), $(".modal-body").html(a.modal_body), "" != a.modal_footer && ($(".modal-footer").show(), $(".modal-footer").html(a.modal_footer)), $("#QuranModal").addClass(a.modal_class), $(".modal-header button").show(), jQuery(".memoz-loading").show(), $.post(a.site_url + "/memoz/list_ajax", {
                filter: "0"
            }, function(a) {
                jQuery(".memoz-list").html(a.html), jQuery(".memoz-loading").hide()
            })
        })
    },
    correctionList: function(a, e) {
        jQuery(".btn-loadmore").show(), "" != a ? jQuery(".btn-loadmore").html("Loading...") : (jQuery("#QuranModal").modal("show"), this.modalLoading(), this.removeModalClass(), jQuery(".memoz-list").hide(), jQuery(".memoz-list").html(""), jQuery(".memoz-loading").show());
        var t = $(".memoz-item").length;
        $.post(this.siteUrl + "/memoz/correction/list", {
            start: t,
            idMemo: e
        }, function(a) {
            "" != a.modal_footer && (jQuery(".modal-footer").show(), jQuery(".modal-footer").html(a.modal_footer)), "0" == a.start ? (jQuery(".modal-title").html(a.modal_title), jQuery(".modal-body").html(a.modal_body)) : jQuery(".btn-loadmore").before(a.modal_body), jQuery(".memoz-list").show(), jQuery(".memoz-loading").hide(), 0 != a.count ? jQuery(".btn-loadmore").html("Selanjutnya") : jQuery(".btn-loadmore").hide(), jQuery(".close").show()
        })
    },
    memozFilter: function(a, e) {
        jQuery(".btn-loadmore").show(), "" != e ? jQuery(".btn-loadmore").html("Loading...") : (jQuery(".memoz-list").hide(), jQuery(".memoz-list").html(""), jQuery(".memoz-loading").show());
        var t = $(".memoz-item").length;
        $.post(this.siteUrl + "/memoz/list_ajax", {
            filter: a,
            start: t
        }, function(a) {
            "0" == a.start ? jQuery(".memoz-list").html(a.html) : jQuery(".btn-loadmore").before(a.html), jQuery(".memoz-list").show(), jQuery(".memoz-loading").hide(), 0 != a.count ? jQuery(".btn-loadmore").html("Selanjutnya") : jQuery(".btn-loadmore").hide()
        })
    },
    memozOthers: function(a, e) {
        jQuery(".btn-loadmore").show(), "" != e ? jQuery(".btn-loadmore").html("Loading...") : (jQuery("#QuranModal").modal("show"), this.modalLoading(), jQuery(".memoz-list").hide(), jQuery(".memoz-list").html(""), jQuery(".memoz-loading").show());
        var t = $(".memoz_filter_others .correction-list-item").length;
        $.post(this.siteUrl + "/memoz/list_others_ajax", {
            filter: a,
            start: t
        }, function(a) {
            "0" == a.start ? (jQuery(".modal-body").html(a.html), jQuery(".modal-footer").html('<button class="btn btn-green-small" data-dismiss="modal">Tutup</button>'), jQuery(".modal-title").html("Hafalan lain"), jQuery(".modal-footer,.close").show()) : jQuery(".btn-loadmore").before(a.html), jQuery(".memoz-loading").hide(), a.count > 0 ? jQuery(".btn-loadmore").html("Selanjutnya") : jQuery(".btn-loadmore").hide()
        })
    },
    needCorrections: function(a) {
        jQuery(".btn-loadmore").show(), "" != a ? jQuery(".btn-loadmore").html("Loading...") : (jQuery("#QuranModal").modal("show"), this.modalLoading(), jQuery(".memoz-list").hide(), jQuery(".memoz-list").html(""), jQuery(".memoz-loading").show());
        var e = $(".corrections_filter_others .correction-list-item").length;
        $.post(this.siteUrl + "/memoz/list_need_corrections_ajax", {
            start: e
        }, function(a) {
            "0" == a.start ? (jQuery(".modal-body").html(a.html), jQuery(".modal-footer").html('<button class="btn btn-green-small" data-dismiss="modal">Tutup</button>'), jQuery(".modal-title").html("Butuh koreksi"), jQuery(".modal-footer,.close").show()) : jQuery(".btn-loadmore").before(a.html), jQuery(".memoz-loading").hide(), a.count > 0 ? jQuery(".btn-loadmore").html("Selanjutnya") : jQuery(".btn-loadmore").hide()
        })
    },
    showInfoMemoz: function() {
        QuranJS.callModal("info_memoz"), $("#QuranModal").modal("show"), $(".modal-title").html("Panduan menghafal")
    },
    stepMemoz: function(e, t) {
        if (void 0 === t.length && (jQuery(".memoz-filter li").removeClass("active"), jQuery(t).parent().addClass("active")), jQuery(".mushaf-hafalan").removeClass("step-1"), jQuery(".mushaf-hafalan").removeClass("step-2"), jQuery(".mushaf-hafalan").removeClass("step-3"), jQuery(".mushaf-hafalan").removeClass("step-4"), jQuery(".mushaf-hafalan").removeClass("step-5"), jQuery(".mushaf-hafalan").addClass("step-" + e), "correction" == e && jQuery(".mushaf-hafalan").addClass("step-4"), jQuery(".ayat_arabic_memoz").removeClass("blur-ayat"), jQuery(".quran_recorder,.steps,.action-footer,.quran_player").hide(), 1 == e) jQuery(".steps,.action-footer,.quran_player").show(), jQuery(".steps_desc p").html('<i class="fa fa-info-circle"></i> Hafalkan dengan teliti target hafalan arabic dan terjemahannya, ulangi muratal sebanyak-banyaknya sampai hafal'), jQuery(".jp-stop").click(), jQuery(".memozed,.memoz_nav").hide(), jQuery("*", ".mushaf").removeClass("playing"), jQuery(".puzzle").hide(), jQuery(".ayat_arabic_memoz").removeClass("puzzle_q"), jQuery(".ayat_arabic_memoz").removeClass("active"), jQuery(".content_ayat .puzzle_border").addClass("puzzle_no_border"), jQuery(".trans").show(), jQuery(".arabic,.memoz_nav").show();
        else if (2 == e) jQuery(".steps,.action-footer,.quran_player").show(), jQuery(".steps_desc p").html('<i class="fa fa-info-circle"></i> Hafalkan dengan teliti target hafalan arabic'), jQuery(".jp-stop").click(), jQuery(".memozed,.memoz_nav").hide(), jQuery("*", ".mushaf").removeClass("playing"), jQuery(".puzzle").hide(), jQuery(".ayat_arabic_memoz").removeClass("puzzle_q"), jQuery(".ayat_arabic_memoz").removeClass("active"), jQuery(".content_ayat .puzzle_border").addClass("puzzle_no_border"), jQuery(".trans").hide(), jQuery(".arabic,.steps,.memoz_nav").show();
        else if (3 == e) jQuery(".steps,.action-footer,.quran_player").show(), jQuery(".steps_desc p").html('<i class="fa fa-info-circle"></i> Fokuskan hafalan terjemahannya dan pelajari tafsir ayatnya'), jQuery(".jp-stop").click(), jQuery(".memoz_nav").hide(), jQuery(".puzzle").hide(), jQuery(".ayat_arabic_memoz").removeClass("puzzle_q"), jQuery(".ayat_arabic_memoz").removeClass("active"), jQuery(".content_ayat .puzzle_border").addClass("puzzle_no_border"), jQuery(".trans,.steps").show(), jQuery(".arabic").hide();
        else if (4 == e || "correction" == e) jQuery(".steps_desc p").html('<i class="fa fa-info-circle"></i> Bacakan setiap kata yang dihilangkan. Jika sudah hafal mulai merekam untuk test hafalan, rekaman akan dikoreksi oleh penghafal lain tau oleh ustadz pilihan QuranMemo.'), jQuery(".jp-stop").click(), jQuery(".memoz_player,.memozed").show(), jQuery(".memoz_nav").show(), jQuery("*", ".mushaf").removeClass("playing"), jQuery(".puzzle").hide(), jQuery(".ayat_arabic_memoz").removeClass("puzzle_q"), jQuery(".ayat_arabic_memoz").removeClass("active"), jQuery(".content_ayat .puzzle_border").addClass("puzzle_no_border"), jQuery(".trans").show(), jQuery(".arabic").show(), jQuery(".trans").show(), jQuery(".arabic").show(), jQuery(".quran_player").hide(), jQuery(".quran_recorder").show();
        else if (5 == e) {
            for (jQuery(".steps_desc p").html('<i class="fa fa-info-circle"></i> PUZZLE...!! Cocokan kata yang hilang secara berurutan'), jQuery(".jp-stop").click(), jQuery(".memoz_player,.memozed,.puzzle").show(), jQuery(".memoz_nav").hide(), jQuery(".ayat_arabic_memoz").addClass("puzzle_q"), jQuery("*", ".mushaf").removeClass("playing"), $(".puzzle" + Math.ceil(2 * Math.random())).show(), jQuery(".trans").hide(), jQuery(".arabic").show(), a = 0; a <= this.totalAyat; a++)
                for (var o = jQuery(".puzzle.puzzle_" + a + " .content_ayat"), i = o.children(); i.length;) o.append(i.splice(Math.floor(Math.random() * i.length), 1)[0]);
            "" == jQuery("#puzzle_word").val() && (jQuery("#puzzle_ayat").val(this.headSurah), jQuery("#puzzle_word").val("1"), jQuery(".arabic_" + this.headSurah + " .content_ayat .puzzle_border").first().removeClass("puzzle_no_border"))
        }
        jQuery(".steps a").removeClass("selected"), jQuery(".steps_" + e).addClass("selected")
    },
    puzzleAnswer: function(a) {
        var e = jQuery("#puzzle_ayat").val(),
            t = jQuery("#puzzle_word").val(),
            o = ".arabic_" + e + " .per_words_" + t,
            i = jQuery(a).data("css");
        e = parseInt(e), t = parseInt(t), o == i ? (jQuery(o).css("visibility", "visible"), jQuery(o).parent().addClass("puzzle_no_border"), jQuery(o).parent().next().removeClass("puzzle_no_border"), jQuery(o).parent().next().removeClass("puzzle_no_border"), o = jQuery(o).parent().next().children().data("css"), jQuery("#puzzle_active").val(o), jQuery(a).remove(), t += 1, jQuery("#puzzle_word").val(t), 0 == jQuery(".puzzle_" + e + " .arabic-puzzle a").length && (jQuery(".puzzle_" + e).remove(), e += 1, jQuery("#puzzle_ayat").val(e), jQuery("#puzzle_word").val("1"), jQuery(".arabic_" + e + " .per_words_1").parent().removeClass("puzzle_no_border"))) : vex.dialog.alert("salah")
    },
    updateCounter: function(a) {
        currVal = parseInt($("." + a + " .counter").html()), $("." + a + " .counter").html(currVal + 1)
    },
    showAyat: function(e) {
        for (jQuery(".ayat_arabic_memoz").removeClass("blur-ayat"), jQuery(".memoz_nav .btn").removeClass("active"), a = 1, jQuery(".btn-" + e).addClass("active"), o = 0; o <= this.totalAyatSpaces.length; o++)
            if ("start" == e)
                for (min = this.totalAyatSpaces[o] >= 10 ? 3 : 2, b = min; b <= this.totalAyatSpaces[o]; b++) jQuery(".arabic_" + o + " .per_words_" + b).addClass("blur-ayat");
            else if ("end" == e)
            for (max = this.totalAyatSpaces[o] >= 10 ? this.totalAyatSpaces[o] - 1 : this.totalAyatSpaces[o], b = 1; b <= this.totalAyatSpaces[o]; b++) b < max && jQuery(".arabic_" + o + " .per_words_" + b).addClass("blur-ayat");
        else if ("mix" == e)
            for (min = this.totalAyatSpaces[o] >= 10 ? 3 : 2, max = this.totalAyatSpaces[o] >= 10 ? this.totalAyatSpaces[o] - 1 : this.totalAyatSpaces[o], b = min; b <= this.totalAyatSpaces[o]; b++) b < max && jQuery(".arabic_" + o + " .per_words_" + b).addClass("blur-ayat");
        else if ("middle" == e)
            for (min = this.totalAyatSpaces[o] >= 10 ? 4 : 2, max = this.totalAyatSpaces[o] >= 10 ? this.totalAyatSpaces[o] - 3 : this.totalAyatSpaces[o], b = 1; b <= this.totalAyatSpaces[o]; b++) b <= min && jQuery(".arabic_" + o + " .per_words_" + b).addClass("blur-ayat"), b >= max && jQuery(".arabic_" + o + " .per_words_" + b).addClass("blur-ayat");
        else if ("random" == e)
            for (b = 1; b <= this.totalAyatSpaces[o]; b++) b % 2 == 0 && jQuery(".arabic_" + o + " .per_words_" + b).addClass("blur-ayat")
    },
    showSearch: function() {
        $("#QuranModal").modal("show"), $(".modal-title").html("Pencarian");
        var a = $(".select-surah").html();
        $(".modal-body").html(a), $(".select2-container").remove(), $(".selectpicker").select2(), $(".modal-footer").html('<button class="btn btn-green-small" data-dismiss="modal">Tutup</button>')
    },
    hidePlayer: function() {
        $(".quran_player").hide(), $(".player-show").show(), $(".player-hide").hide()
    },
    showPlayer: function() {
        $(".quran_player").show(), $(".player-show").hide(), $(".player-hide").show()
    },
    createMemoModal: function() {
        this.formMemoModal("")
    },
    formMemoCorrectionShow: function(a) {
        $(".note").hide(), $(".btn-close").show(), $(".action-footer").slideToggle()
    },
    formMemoCorrectionClose: function() {
        $(".note").show(), $(".btn-close").hide(), $(".action-footer").slideToggle()
    },
    saveMemozCorrection: function() {
        $(".label-loading").show(), id = $("#id").val();
        var a = "";
        $(" .wrong").each(function(e) {
            a += $(this).data("css") + "|"
        }), $.post(this.siteUrl + "/memoz/saveCorrection", {
            id_memo_target: id,
            note: $("#note").val(),
            record_file: $("#record_file").val(),
            correction: a,
            points: $(".points").val(),
            status_memoz_correction: $(".status_memoz_correction").val()
        }, function(a) {
            $(".label-loading").hide(), $("#QuranModal").modal("hide"), vex.dialog.alert("Koreksi sudah dikirim")
        })
    },
    formMemoModal: function(a) {
        this.modalLoading(), $("#QuranModal").modal("show"), $(".modal-title").html("Simpan Hafalan"), $.post(this.siteUrl + "/memoz/form", {
            surah_start: $(".surah_start_temp").val(),
            ayat_start: $(".ayat_start_temp").val(),
            ayat_end: $(".ayat_end_temp").val(),
            id: a
        }, function(a) {
            $(".modal-title").html(a.modal_title), $(".modal-body").html(a.modal_body), $(".modal-footer").html(a.modal_footer), $(".modal-header button").show(), $(".input-daterange").datepicker({
                format: "yyyy-mm-dd",
                clearBtn: !0,
                autoclose: !0,
                todayHighlight: !0
            })
        })
    },
    saveMemoz: function(a) {
        $(".label-loading").show(), $(".label-save").hide(), $.post(this.siteUrl + "/memoz/save", {
            id: a,
            surah_start: $("#surah_start").val(),
            ayat_start: $("#ayat_start").val(),
            ayat_end: $("#ayat_end").val(),
            date_start: $("#date_start").val(),
            date_end: $("#date_end").val(),
            note: $("#note_memoz").val()
        }, function(a) {
            vex.dialog.alert(a.message), $(".label-loading").hide(), $(".label-save").show(), $("#id").val(a.id), 1 == a.status && (location.href = a.siteUrl + "/memoz/surah/" + a.surah_start + "/" + a.ayat_start + "-" + a.ayat_end + "/" + a.id)
        })
    },
    updateStatusMemoz: function(a, e, t) {
        a = a, e = e, t = t;
        var o = this.siteUrl;
        vex.dialog.confirm({
            message: t,
            callback: function(t) {
                1 == t && ($(".label-status-loading").show(), $(".label-status-save").hide(), $.post(o + "/memoz/updateStatus", {
                    id: a,
                    status: e
                }, function(a) {
                    $(".label-status-loading").hide(), $(".label-status-save").show(), 1 == a.status && ($(".text_status_memoz").html(a.text_status), $(".memoz-item.memoz-" + a.id).slideUp())
                }))
            }
        })
    },
    deleteMemoz: function(a) {
        a = a;
        var e = this.siteUrl;
        vex.dialog.confirm({
            message: "Yakin hafalan ini di hapus?!",
            callback: function(t) {
                1 == t && ($(".label-status-loading").show(), $(".label-save").hide(), $.post(e + "/memoz/remove", {
                    id: a
                }, function(a) {
                    $(".label-status-loading").hide(), $(".label-save").show(), 1 == a.status ? $(".memoz-" + a.id).slideUp() : vex.dialog.alert(a.message)
                }))
            }
        })
    },
    correctionMemoz: function(a, e) {
        $(".mushaf-hafalan").hasClass("step-4") && ($(".arabic_" + a + " .per_words_" + e).hasClass("wrong") ? $(".arabic_" + a + " .per_words_" + e).removeClass("wrong") : $(".arabic_" + a + " .per_words_" + e).addClass("wrong"), $(" .wrong").each(function(a) {
            console.log(a + ": " + $(this).data("css")), $("#btn-correction").show()
        }))
    },
    setBookmark : function(title, url){
  		var hasClass = jQuery('#bookmark').hasClass('fa-bookmark-o');
  		if(hasClass==true){
  			document.cookie = 'coo_mushaf_bookmark_title='+title+';visited=true;path=/;';
  			document.cookie = 'coo_mushaf_bookmark_url='+url+';visited=true;path=/;';
  			jQuery('#bookmark').removeClass('fa-bookmark-o');
  			jQuery('#bookmark').addClass('fa-bookmark');
  			$('.bookmark-sign').slideDown()
  			//vex.dialog.alert(title+' - telah di tandai halaman terakhir dibaca');
  		}else{
  			document.cookie = 'coo_mushaf_bookmark_title=;visited=true;path=/;';
  			document.cookie = 'coo_mushaf_bookmark_url=;visited=true;path=/;';
  			jQuery('#bookmark').removeClass('fa-bookmark');
  			jQuery('#bookmark').addClass('fa-bookmark-o');
  			//vex.dialog.alert('Halaman terakhir dibaca dihapus');
  			$('.bookmark-sign').slideUp()
  		}

  	},

    bookmarkModal: function(a, e) {
        var t = this.siteUrl + "/mushaf/page/1";
        if ("" == a) return location.href = t, !1;
        var o = '<div class="center">';
        o += "<h4>Lanjut baca " + a + "<h4>", o += '<button class="btn btn-green-small" onclick="location.href=\'' + e + "'\">Ya</button> ", o += '<button class="btn btn-green-small"  onclick="location.href=\'' + t + "'\">Tidak</button>", o += "</div>", $(".modal-title").html("Halaman terakhir dibaca"), $(".modal-body").html(o), $(".modal-footer").show(), $(".modal-footer").html('<button class="btn btn-green-small" data-dismiss="modal">Tutup</button>'), $(".modal-header button").show(), $("#QuranModal").modal("show")
    },
    authProcess: function() {
        $(".label-loading").show(), $(".label-masuk").hide(), $.post(this.siteUrl + "/auth/loginAction", {
            email: $("#login_email").val(),
            password: $("#login_password").val()
        }, function(a) {
            1 == a.login ? (document.cookie = "coo_quranmemo_email=" + a.coo_quranmemo_email + ";visited=true;path=/;", document.cookie = "coo_quranmemo_password=" + a.coo_quranmemo_password + ";visited=true;path=/;", location.href = a.redirect) : vex.dialog.alert(a.errorMessage), $(".label-masuk").show(), $(".label-loading").hide()
        })
    },
    forgetProcess: function() {
        $(".label-loading").show(), $(".label-masuk").hide(), $.post(this.siteUrl + "/auth/forgetProcess", {
            email: $("#login_email").val()
        }, function(a) {
            1 == a.return ? vex.dialog.alert("Password sudah dikirim ke email, silahkan cek Inbox email, jika tidak ada cek SPAM folder.") : vex.dialog.alert("Email tidak terdaftar, silahkan daftar terlebih dahulu"), $(".label-masuk").show(), $(".label-loading").hide()
        })
    },
    uploadAvatar: function() {
        $("#btn-upload").val("Uploading..."), $("#btn-upload").prop("disabled", !0);
        var a = new FormData;
        a.append("avatar", $("#avatar")[0].files[0]), $.ajax({
            url: this.siteUrl + "/profile/uploadAvatar",
            type: "POST",
            data: a,
            contentType: !1,
            cache: !1,
            processData: !1,
            success: function(a) {
                "false" == a ? vex.dialog.alert("Upload avatar gagal") : (vex.dialog.alert("Upload avatar sukses"), $("#img_avatar").attr("src", a)), $("#btn-upload").val("Upload"), $("#btn-upload").removeAttr("disabled")
            }
        })
    },
    updateInProgress: function(a) {
        $(".label-status-loading").show(), $.post(this.siteUrl + "/memoz/inProgress", {
            id: a
        }, function(a) {
            1 == a.status ? ($(".memoz-item.memoz-" + a.id).detach().prependTo(".memoz_filter_0").hide().slideDown(), $(".memoz-item i.fa-star").removeClass("fa-star").addClass("fa-star-o"), $(".memoz-item.memoz-" + a.id + " i.fa-star-o").addClass("fa-star").removeClass("fa-star-o"), vex.dialog.alert("Berhasil di update")) : vex.dialog.alert("Gagal di update"), $(".label-status-loading").hide()
        })
    },
    submitMemoz: function(a) {
        return surah = $("#surah_start").val(), 1 == surah || surah >= 78 ? (jQuery(".form-inline").submit(), !0) : a >= 1 ? (jQuery(".form-inline").submit(), !0) : (this.callModal("subscription"), !0)
    },
    memozStar: function(a, e, t) {
        switch ($(".memoz-starts button").removeClass("btn-primary"), $(".memoz-starts button").removeClass("btn-danger"), $(".memoz-starts button").removeClass("btn-success"), $(".memoz-starts button").removeClass("btn-warning"), $(".status_memoz_correction").val(e), $(".points").val(t), e) {
            case 0:
                $(a).addClass("btn-danger");
                break;
            case 1:
                $(a).addClass("btn-warning");
                break;
            case 2:
                $(a).addClass("btn-primary");
                break;
            case 3:
                $(a).addClass("btn-success")
        }
    },

    showSearchForm: function(){
      this.modalLoading();
      $("#QuranModal").modal("show");
      $(".modal-title").html("Cari Ayat");
      $.get(this.siteUrl + "/mushaf/search_form", {

      }, function(a) {
          $(".modal-title").html(a.modal_title);
            $(".modal-body").html(a.modal_body);
            $(".modal-footer").html(a.modal_footer);
            $(".modal-header button").show()
      })
    },
};
