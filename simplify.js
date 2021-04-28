class Simplify {
    constructor() {
        this.page = {
            'url': location.href,
            'name': document.title,
            'location':location
        }
    }

    secureUplaodPage() {
        var _this = this

        $('#submit-secure-file').on('click', function (e) {
            e.preventDefault();
            let dataId = CryptoJS.MD5($(this).parents('form').find('[name="data-id"]').val()).toString();
            
            _this.setCookie('clavis-' + _this.getCookie('PHPSESSID'), dataId)
            if ($(this).parents('form').find('[name="file"]')[0].files.length > 0) {
                _this.setCookie('file-' + _this.getCookie('PHPSESSID'), $(this).parents('form').find('[name="file"]')[0].files[0].name)
            }
            let form = document.getElementById("secure-form");

            let pristine = new Pristine(form);
            let valid = pristine.validate(); // returns true or false
            
            if ($(this).parents('form').find('[name="file"]')[0].files.length == 0) {
                valid =false;
                $(this).parents('form').find('[name="file"]').parents('.form-group').removeClass('has-success').addClass('has-danger');
                $(this).parents('form').find('[name="file"]').parents('.form-group').find('.pristine-error').text('Please add a file').show();
            
            }

            if (valid == true) {
                $(this).parents('form').submit();
            }
        })

        $('#new-tax-submit').on('click', function (e) {
            e.preventDefault();

            let form = document.getElementById("tax-setup");

            let pristine = new Pristine(form);
            let valid = pristine.validate(); // returns true or false

            
        })


        $('#direct-deposit-submit').on('click', function (e) {
            e.preventDefault();

            let form = document.getElementById("direct-deposit");

            let pristine = new Pristine(form);
            let valid = pristine.validate(); // returns true or false

            console.log($(this).parents('form').find('[name="checkimg"]'))

            if ($(this).parents('form').find('[name="checkimg"]')[0].files.length == 0) {
                valid =false;
                $(this).parents('form').find('[name="checkimg"]').parents('.form-group').removeClass('has-success').addClass('has-danger');
                $(this).parents('form').find('[name="checkimg"]').parents('.form-group').find('.pristine-error').text('Please add a file').show();
            
            }

            if (valid == true) {
                $(form).find('#isvalid').val('iamvalid');
                if (window.location.href.indexOf('?form')>0) {
                   $(form).attr('action', window.location.pathname + '?form=direct-deposit');
                } else {
                    $(form).attr('action', '?form=direct-deposit');
                }
               
                $(form).submit();
            }

        })

        $('#new-employee-submit').on('click', function (e) {
            e.preventDefault();

            let form = document.getElementById("new-employee");

            let pristine = new Pristine(form);
            let valid = pristine.validate(); // returns true or false


            if (valid == true) {
                $(form).find('#isvalid').val('iamvalid');
                if (window.location.href.indexOf('?form')>0) {
                   $(form).attr('action', window.location.pathname + '?form=new-employee');
                } else {
                    $(form).attr('action', '?form=new-employee');
                }
               
                $(form).submit();
            }


        })

        $('#new-employee-print').on('click', function (e) {
            e.preventDefault();
          
            window.print();
        })

        $('input.file').on('change',function () {
            $(this).next('span.file-info').html($(this)[0].files[0].name)
        })


        $('li.form').on('click', function () {
            let id = $(this).attr('data-id');
            if (id !=undefined) {
                $('form.form').each(function () {
                    $(this).hide();
                });
                $('form#'+id).show();
            }
        });

        if (_this.getUrlParams('form')==undefined) {
            $('form.form').each(function () {
                $(this).hide();
            });
            $('#secure-form').show();
        } else {
            $('form.form').each(function () {
                $(this).hide();
            });
            $('form#'+_this.getUrlParams('form')).show();  
        }
        
        $("input.date").flatpickr();
        
        
        
    }

    getUrlParams =  function(name){
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results==null) {
           return null;
        }
        return decodeURI(results[1]) || 0;
    }

    getCookie = function(sName) {
        sName = sName.toLowerCase();
        var oCrumbles = document.cookie.split(';');
        for(var i=0; i<oCrumbles.length;i++)
        {
            var oPair= oCrumbles[i].split('=');
            var sKey = decodeURIComponent(oPair[0].trim().toLowerCase());
            var sValue = oPair.length>1?oPair[1]:'';
            if(sKey == sName)
                return decodeURIComponent(sValue);
        }
        return '';
    }

    setCookie = function(sName,sValue) {
        var oDate = new Date();
        oDate.setYear(oDate.getFullYear()+1);
        var sCookie = encodeURIComponent(sName) + '=' + encodeURIComponent(sValue) + ';expires=' + oDate.toGMTString() + ';path=/';
        document.cookie= sCookie;
    }

    clearCookie = function(sName)
    {
        setCookie(sName,'');
    }
    
} //end Simplify class

   var simplify = new Simplify();

setTimeout(function () {
    

    $(document).ready(function () {
        if ($('#secure-upload-page').length > 0) {
            simplify.secureUplaodPage();
        } 
    })

},500)