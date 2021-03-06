class Simplify {
    constructor() {
        this.page = {
            'url': location.href,
            'name': document.title,
            'location':location
        }
    }

    init() {
        if (jQuery('#top-menu-nav').length > 0) {
            if (jQuery('#top-menu-nav').find('li.menu-item-has-children').length>0) {
                jQuery('#top-menu-nav').find('li.menu-item-has-children').find('a:first').addClass('nogo')

                jQuery('a.nogo').on('click', function (e) {
                    e.preventDefault();
                })
            }
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
                $(this).text('Sending');
                $(this).parents('form').submit();
            }
        })

        $('#tax-submit').on('click', function (e) {
            e.preventDefault();

            let form = document.getElementById("tax-setup");

            let pristine = new Pristine(form);
            let valid = pristine.validate(); // returns true or false


            if ($('select.required').length > 0 ) {

                $('select.required').each(function () {
                    if ($(this).val() == $(this).attr('data-default-val')) {
                        let msg = $(this).attr('data-pristine-required-message')
                        $(this).parents('.form-group').removeClass('has-success').addClass('has-danger');
                        $(this).parents('.form-group').find('.pristine-error').text(msg).show();
                        valid = false;
                    }

                })
            }

            if ($(this).parents('form').find('[name="file"]')[0].files.length == 0) {
                valid =false;
                $(this).parents('form').find('[name="file"]').parents('.form-group').removeClass('has-success').addClass('has-danger');
                $(this).parents('form').find('[name="file"]').parents('.form-group').find('.pristine-error').text('Please add a file').show();

            }

            if (valid == true) {
                $(form).find('#isvalid').val('iamvalid');
                $(this).text('Sending');
                $('#validate-status').hide();
                $(form).submit();
            } else {
                if ($('#status').length ==0) {
                    $('validate-status').show();
                    $('<span />', {
                        'id': 'validation-status',
                        'style': 'color: red;',
                        'text': 'There is an issue with your form.  Please check the form and try again.'
                    }).insertAfter('#tax-submit')
                }
            }

        })


        $('#direct-deposit-submit').on('click', function (e) {
            e.preventDefault();

            let form = document.getElementById("direct-deposit");

            let pristine = new Pristine(form);
            let valid = pristine.validate(); // returns true or false


            if ($(this).parents('form').find('[name="checkimg"]')[0].files.length == 0) {
                valid =false;
                $(this).parents('form').find('[name="checkimg"]').parents('.form-group').removeClass('has-success').addClass('has-danger');
                $(this).parents('form').find('[name="checkimg"]').parents('.form-group').find('.pristine-error').text('Please add a file').show();

            }

            if (valid == true) {
                $(form).find('#isvalid').val('iamvalid');
                $(this).text('Sending');
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
                $(this).text('Sending');
                $(form).submit();
            }


        })

        $('.close').on('click', function () {
            $('#status').hide();
        })

        $('.address').on('change', function () {
            if ($('input#sameasdelivery').is(':checked') == true) {
                let id = $(this).attr('data-phys');
                console.log(id);
                console.log($(this).val())
                $('#'+id).val($(this).val())
            }
        })

        $('input#sameasdelivery').on('change', function () {  
            if ($(this).is(":checked") == true) {
                $('input#physical_address').val($('#mailing_address').val()).attr('readonly', true);
                $('input#physical_city').val($('#mailing_city').val()).attr('readonly', true);
                $('select#physical_state').val($('#mailing_state').val()).attr('disabled', true);
                $('input#physical_zip').val($('#mailing_zip').val()).attr('readonly', true);
            } else {
                $('input#physical_address').removeAttr('readonly');
                $('input#physical_city').removeAttr('readonly');
                $('select#physical_state').removeAttr('disabled');
                $('input#physical_zip').removeAttr('readonly');

            }
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

        $('#new-party').on('click',function (e) {
            e.preventDefault();
            let max = $(this).attr('data-max');
            let numele = $('.resp-party-wrap').length;
            if (max > numele) {
                $('.resp-party-wrap.org').clone().insertAfter('.resp-party-wrap.org');

                $('.resp-party-wrap').each(function (index,val) {
                    if (index > 0) {
                        let realindex = parseInt(index + 1)
                        $(this).removeClass('org');
                        $(this).attr('data-index', realindex);
                        $(this).find('p.respparty').text('Responsible Party ' + realindex)
                        $(this).find('input.party_name').attr('id', 'party_name_' + realindex).attr('name', 'party_name_' + realindex)
                        $(this).find('input.ssn').attr('id', 'ssn_' + realindex).attr('name', 'ssn_' + realindex)
                        $(this).find('input.title').attr('id', 'title_' + realindex).attr('name', 'title_' + realindex)
                        $(this).find('input.phone').attr('id', 'phone_' + realindex).attr('name', 'phone_' + realindex)
                        $(this).find('input.email').attr('id', 'email_' + realindex).attr('name', 'email_' + realindex)
                        $(this).find('input.resp_address').attr('id', 'resp_address_' + realindex).attr('name', 'resp_address_' + realindex)
                        $(this).find('input.resp_city').attr('id', 'resp_city_' + realindex).attr('name', 'resp_city_' + realindex)
                        $(this).find('select.resp_state').attr('id', 'resp_state_' + realindex).attr('name', 'resp_state_' + realindex)
                        $(this).find('input.resp_zip').attr('id', 'resp_zip_' + realindex).attr('name', 'resp_zip_' + realindex)
                    }
                })
            }
        })

        $('input.date').each(function () {
            flatpickr(this);
        });

        $('select.states').each(function () {
          var select = this;
          var states = {"na": "Select State", "AL": "Alabama","AK": "Alaska","AS": "American Samoa","AZ": "Arizona","AR": "Arkansas","CA": "California","CO": "Colorado","CT": "Connecticut","DE": "Delaware","DC": "District Of Columbia","FM": "Federated States Of Micronesia","FL": "Florida","GA": "Georgia","GU": "Guam","HI": "Hawaii","ID": "Idaho","IL": "Illinois","IN": "Indiana","IA": "Iowa","KS": "Kansas","KY": "Kentucky","LA": "Louisiana","ME": "Maine","MH": "Marshall Islands","MD": "Maryland","MA": "Massachusetts","MI": "Michigan","MN": "Minnesota","MS": "Mississippi","MO": "Missouri","MT": "Montana","NE": "Nebraska","NV": "Nevada","NH": "New Hampshire","NJ": "New Jersey","NM": "New Mexico","NY": "New York","NC": "North Carolina","ND": "North Dakota","MP": "Northern Mariana Islands","OH": "Ohio","OK": "Oklahoma","OR": "Oregon","PW": "Palau",  "PA": "Pennsylvania","PR": "Puerto Rico","RI": "Rhode Island",  "SC": "South Carolina","SD": "South Dakota","TN": "Tennessee","TX": "Texas","UT": "Utah","VT": "Vermont" , "VI": "Virgin Islands","VA":"Virginia","WA":"Washington","WV": "West Virginia","WI": "Wisconsin","WY": "Wyoming"
          }

          $.each(states, function (index, val) {
            $('<option />', {
                'value': index,
                'text': val
            }).appendTo(select)
          })

        })

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

    jQuery(document).ready(function () {
       if (jQuery('#secure-upload-page').length > 0) {
            simplify.secureUplaodPage();
        }

        simplify.init();
    })

},500)
