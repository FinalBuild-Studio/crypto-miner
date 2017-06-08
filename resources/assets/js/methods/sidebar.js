var url = window.url;

$('.sidebar-wrapper li').removeClass('active');
$(`.sidebar-wrapper a[href="${url}"]`).parent().addClass('active');
