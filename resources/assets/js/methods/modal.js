var confirmModalTempalte = '' +
  '<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-label" aria-hidden="true" style="display: none;">' +
    '<div class="modal-dialog">' +
      '<div class="modal-content">' +
        '<div class="modal-header">' +
          '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">' +
            '<i class="material-icons">clear</i>' +
          '</button>' +
          '<h4 class="modal-title">$title</h4>' +
        '</div>' +
        '<div class="modal-body">' +
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
          '</form>' +
        '</div>' +
        '<div class="modal-footer">' +
          '<button type="button" class="btn btn-simple confirm">確認</button>' +
          '<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">取消</button>' +
        '</div>' +
      '</div>' +
    '</div>' +
  '</div>' +
'</div>';

$('.confirm-button').on('click', event => {
  event.preventDefault();

  var $this = $(event.currentTarget);
  var isThoughAjax = $this.data('ajax');
  var actionTarget = $this.data('action');
  var actionMethod = $this.data('method');
  var actionMessage = $this.data('message');
  var actionTitle = $this.data('title');
  var payload = $this.data('payload') || {};
  var template = confirmModalTempalte;

  // add template
  template = template.replace(/\$message/, actionMessage);
  template = template.replace(/\$title/, actionTitle);

  $('#modal').remove();
  $('#modal').closest('.modal-backdrop').remove();
  $('body').append(template);

  $('#modal').on('hidden.bs.modal', e => {
    var modal = $(e.currentTarget);
    $(modal).remove();
    $(modal).closest('.modal-backdrop').remove();
  });

  $('#modal').on('show.bs.modal', e => {
    var modal = $(e.currentTarget);
    $(modal).find('.confirm').on('click', event => {
      if (isThoughAjax) {
        $(modal).find('form').on('submit', event => {
          event.preventDefault();

          var form = $(event.currentTarget);
          $.each($(form).find(':input'), (key, value) => {
            var input;
            var val = $(value).val();
            var type = $(value).attr('type');

            if (!isNaN(val * 1)) {
              val = parseFloat(val);
            }

            switch (type) {
              case 'checkbox':
              case 'radio':
                if ($(value).prop('checked')) {
                  input = val;
                }
                break;
              default:
                input = val;
                break;
            }

            if (input) {
              payload[$(value).attr('name')] = input;
            }
          });

          $.ajax({
            url: actionTarget,
            method: actionMethod,
            dataType: 'json',
            data: JSON.stringify(payload),
            success: (data, statusCode, jqXHR) => {
              $this.trigger('confirm-action-done', data);
            },
            error: (jqXRH, statusCode, errorThrown) => {
              $this.trigger('confirm-action-failed', errorThrown);
            },
            complete: (jqXRH, statusCode, errorThrown) => {
              $(modal).modal('hide');
            }
          });
        });
      } else {
        $(modal).find('form').attr('action', actionTarget);
        if (actionMethod === 'POST' || actionMethod === 'GET') {
          $(modal).find('#confirm-modal-form-method-template-target').html('');
        } else {
          var formMethodTemplate = $(modal).find('#confirm-modal-form-method-template').html();
          $(modal)
            .find('#confirm-modal-form-method-template-target')
            .html(formMethodTemplate.replace(/\$method/g, actionMethod));
        }

        payload._token = document.head.querySelector('meta[name="csrf-token"]').content;
        var payloadTempalte = $(modal).find('#confirm-modal-payload-template').html();
        var payloads = Object.keys(payload)
          .map(function(key) {
            var field = payloadTempalte;
            field = field
              .replace(/\$key/g, key)
              .replace(/\$value/g, payload[key]);
            return field;
          });

        $(modal).find('#confirm-modal-payload-template-target').html(payloads);
      }

      $(modal).find('form').submit();
    });
  });

  $('#modal').modal();
});
