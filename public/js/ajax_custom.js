$(document).ready(function () {
    $('.loader-overlay').hide();
    $('#clear-form-data').on('click', function () {
        $('#listing-filter-data .form-control').val('');
        $('#listing-filter-data .select2').val('').trigger('change');
    });
});
$(document).on('click', '.confirm-logout', function (e) {
    e.preventDefault();
    var message = 'Are you sure you want to logout?';
    let url = $(this).attr('href');
    if (!url){
        url = './logout';
    }
    bootbox.confirm({
        message: message,
        buttons: {
            confirm: {
                label: 'Yes I confirm',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            if (result) {
                $.ajax({
                    type: 'get',
                    url: url,
                    success: function () {
                        // location.reload();
                        window.location.href = '/webadmin';
                    }
                });
            }
        }
    })
})

$(document).on('click','#togglePassword',function() {
    var passwordField = $("#password");
    var passwordFieldType = passwordField.attr("type");

    if (passwordFieldType === "password") {
        passwordField.attr("type", "text");
        $("#togglePassword").removeClass("fa-eye-slash").addClass("fa-eye");
    } else {
        passwordField.attr("type", "password");
        $("#togglePassword").removeClass("fa-eye").addClass("fa-eye-slash");
    }
});
function submitForm(form_id, form_method, errorOverlay = '') {
    $('.loader-overlay').show();
    var form = $('#' + form_id);
    var formdata = false;
    if (window.FormData) {
        formdata = new FormData(form[0]);
    }

    var can = 0;
    $('#' + form_id).find(".required").each(function(){
        var here = $(this);
        var value = here.val();
        if (!value || (Array.isArray(value) && value.length === 0) || (typeof value === 'string' && value.trim() === '')) {
            if (here.attr('type') === 'file' && here.closest('.input-file').length !== 0 ) {
                here.addClass('border-danger');
                here.closest('.input-file').css('border', '1px solid red');
            } else {
                here.addClass('border-danger');
                here.siblings('.select2-container').find('.selection .select2-selection').addClass('border-danger');
                // multiple select2 filed required
                here.next('.select2-container').
                    find('.selection .select2-selection--multiple').
                    addClass('border-danger');
            }
            can++;
        }
    });
    if(can > 0) {
        $('.loader-overlay').hide();
    }
    if(can == 0) {
        if($('.translation_block').length > 0) {
            translation_block_key = [];
            translation_block_lang = [];
            trans = {};
            var i=0;
            arr = [];
            $('.translation_block').each(function() {
                arr = (($(this).prop('id')).split('_'));
                translation_block_key[i] = ($(this).prop('id')).replace("_"+arr[arr.length-1], "");
                translation_block_lang[i] = arr[arr.length-1];
                i++;
            });
            keys = translation_block_key.filter(onlyUnique);
            lang = translation_block_lang.filter(onlyUnique);
            translated_data = [];

            for(i=0; i < keys.length; i++) {
                test = {};
                for(j=0; j < lang.length; j++) {
                    test[lang[j]] = nl2br($('#'+keys[i]+'_'+lang[j]).val());
                }
                trans[keys[i]] = test;
                formdata.append(keys[i], JSON.stringify(test));
            }
        }
        $.ajax({
            url: form.attr('action'),
            type: form_method,
            dataType: 'json',
            data: formdata,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                $('.loader-overlay').hide();
                if (response.success == 0) {
                    let message = '';

                    if (Array.isArray(response.message)) {
                        message = response.message.join('<br>');
                    } else {
                        message = response.message;
                    }
                    toastr.error(message);
                } else {
                    toastr.success(response.message);
                    setTimeout(function () {
                        if(response.data && response.data.redirect_url){
                            window.location.href = response.data.redirect_url;
                        } else {
                            window.history.back();
                        }
                    }, 2000);
                }
            }
        });
    } else {
        var ih = $('.border-danger').last().closest('.tab-pane').attr('id');
        $('a[href="#'+ih+'"]').click();
    }
}

function handleFileInputOnChange(inputId, outputId, type = null) {
    var fileInput = document.getElementById(inputId);
    var file = fileInput.files[0];
    var output = document.getElementById(outputId);
    output.innerHTML = '';

    if (file) {
        var listItem = document.createElement('span');
        listItem.classList.add('file-block', 'p-2');

        var fileName = document.createElement('span');
        fileName.textContent = file.name;
        listItem.appendChild(fileName);

        var cancelButton = document.createElement('span');
        cancelButton.innerHTML = '&times;';
        cancelButton.classList.add('cancel-icon');
        cancelButton.style.cursor = 'pointer';
        cancelButton.style.marginLeft = '10px';
        cancelButton.addEventListener('click', function() {
            output.innerHTML = '';
            fileInput.value = "";
        });
        listItem.appendChild(cancelButton);

        output.appendChild(listItem);
    }
}

function validateNumberInput(input) {
    const value = parseInt(input.value);
    if (isNaN(value) || value <= 0 || value !== parseInt(input.value)) {
        input.value = '';
    }
}

function handleMultipleImageShow() {

    const attachmentInput = document.getElementById('image');

    // 🔥 IMPORTANT: Create DataTransfer object
    let multipleDocumentData = new DataTransfer();

    attachmentInput.addEventListener('change', function () {

        for (let i = 0; i < this.files.length; i++) {

            const file = this.files[i];

            // Add file to DataTransfer
            multipleDocumentData.items.add(file);

            // Create UI block
            const fileBloc = $('<span/>', { class: 'file-block' });
            const fileName = $('<span/>', { class: 'name', text: file.name });

            fileBloc.append(
                $('<span/>', { 
                    class: 'file-delete extra-file-delete cursor-pointer',
                    html: '<span>×</span>'
                })
            ).append(fileName);

            $('#files-names').append(fileBloc);
        }

        // Update input files
        attachmentInput.files = multipleDocumentData.files;

        // Delete file
        $('.extra-file-delete').off('click').on('click', function () {

            const name = $(this).next('.name').text();

            for (let i = 0; i < multipleDocumentData.items.length; i++) {
                if (name === multipleDocumentData.items[i].getAsFile().name) {
                    multipleDocumentData.items.remove(i);
                    break;
                }
            }

            $(this).parent().remove();
            attachmentInput.files = multipleDocumentData.files;
        });

    });
}

$(document).on('click', '.delete-product', function (e) {
    e.preventDefault();
    let productName = $(this).data('product_name') || 'this product';
    var message = 'Are you sure you want to delete ' + productName + ' ?';
    let url = $(this).data('url');
    bootbox.confirm({
        message: message,
        buttons: {
            confirm: {
                label: 'Yes I confirm',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            if (result) {
                $.ajax({
                    type: 'get',
                    url: url,
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status) {
                            location.reload();
                        } else {
                            toastr.error(response.message);
                        }
                    }
                });
            }
        }
    })
})