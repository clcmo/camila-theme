/* Seletor da biblioteca de mídia nos campos de áudio. */
jQuery(function ($) {
  $('[data-clo-midia]').on('click', function (e) {
    e.preventDefault();
    const campo = $('#' + $(this).data('clo-midia'));
    const quadro = wp.media({ title: 'Escolher áudio', library: { type: 'audio' }, multiple: false });
    quadro.on('select', function () { campo.val(quadro.state().get('selection').first().toJSON().url); });
    quadro.open();
  });
});
