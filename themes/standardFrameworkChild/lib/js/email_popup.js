$ = jQuery;
$(window).on('load', function () {
    var btn = $('.download-button');
    var form = $(this).attr('email_form');
    var submit = $('.review');
    var font = '';
    $(function() {
        $(btn).click(function () {
            font = this.id;
            $(form).css("display", "block");
            $(form).dialog('open');
            document.getElementById('title').innerHTML = 'Request for ' + font + ' License';
            return false;
        });
        $(form).dialog({
            autoOpen: false,
            modal: true,
            dialogClass: 'dialog_drop-shadow',
            width: 'auto',
            height: 'auto',
            resizable: false
        });

        $('.ui-widget-overlay').live("click", function () {
            $(form).dialog("close");
        });

        $(submit).click(function () {
            var formValues = [];
            // get values from inputs in first fieldset
            $('.field1 :input').each(function () {
                formValues.push($(this).val());
            });

            formValues.pop(); //remove the button from input values
            var department = formValues[0] + ' Department%0D%0A';
            var contact = formValues[1] + ' ' + formValues[2] + '%0D%0A';
            var email = formValues[3] + '%0D%0A';
            var extension = 'EXT: ' + formValues[4] + '%0D%0A';
            var macLicense = formValues[5] + ' License(s) for Mac%0D%0A';
            var windowsLicense = formValues[6] + ' License(s) for Windows%0D%0A';
            var billing = 'Account #: ' + formValues[7] + '%0D%0A';
            window.location = 'mailto:natalie_miles@byu.edu?Subject=Request For Font License&Body=Natalie,%0D%0A%0D%0AI would like to request a license for the '
                + font + ' font%0D%0A'
                + department
                + contact
                + email
                + extension
                + macLicense
                + windowsLicense
                + billing
                + '%0D%0AThank You';
        });
    });
});

