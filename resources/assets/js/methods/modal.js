var confirmModalTempalte = '' +
  '<form method="POST">' +
    '<div class="hidden">' +
      '<script type="text/html" id="confirm-modal-payload-template">' +
        '<input type="hidden" name="$key" value="$value">' +
      '</script>' +
      '<div id="confirm-modal-payload-template-target"></div>' +
      '<script type="text/html" id="confirm-modal-form-method-template">' +
        '<input type="hidden" name="_method" value="$method">' +
      '</script>' +
      '<div id="confirm-modal-form-method-template-target"></div>' +
    '</div>' +
    '$message' +
  '</form>';

$('.confirm-button').on('click', function(event) {
  var $this = $(this);
  var isThoughAjax = $this.data('ajax');
  var actionTarget = $this.data('action');
  var actionMethod = $this.data('method').toUpperCase();
  var payload = $this.data('payload') || {};
  var title = $this.data('title');
  var message = confirmModalTempalte.replace(/\$message/, $this.data('message'));

  $.dialog.show({
    title: title,
    message: message,
    buttons: [{
      label: '取消',
      action: (dialog) => {
        dialog.close();
      }
    }, {
      label: '確定',
      cssClass: 'btn-primary',
      action: (dialog) => {
        var modal = dialog.$modal;

        if (isThoughAjax) {

          modal.find('form').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
              url: actionTarget,
              method: actionMethod,
              dataType: 'json',
              data: payload,
              success: function(data, statusCode, jqXHR) {
                $this.trigger('confirm-action-done', data);
              },
              error: function(jqXRH, statusCode, errorThrown) {
                $this.trigger('confirm-action-failed', errorThrown);
              },
              complete: function(jqXRH, statusCode, errorThrown) {
                dialog.close();
              }
            });
          });
        } else {
          modal.find('form').attr('action', actionTarget);

          if (actionMethod === 'POST' || actionMethod === 'GET') {
            modal.find('#confirm-modal-form-method-template-target').html('');
          } else {
            var formMethodTemplate = modal.find('#confirm-modal-form-method-template').html();

            modal
              .find('#confirm-modal-form-method-template-target')
              .html(formMethodTemplate.replace(/\$method/g, actionMethod));
          }

          payload._token = document.head.querySelector('meta[name="csrf-token"]').content;

          var payloadTempalte = modal.find('#confirm-modal-payload-template').html();
          var payloads = Object.keys(payload)
            .map(function(key) {
              var field = payloadTempalte;

              field = field
                .replace(/\$key/g, key)
                .replace(/\$value/g, payload[key]);

              return field;
            });

          modal.find('#confirm-modal-payload-template-target').html(payloads);
        }

        modal.find('form').submit();
      }
    }]
  });
});
