( function( $ ) {
  wp.customize( 'media_player_styles[main_background]', function( value ) {
    value.bind( function( to ) {
      $( '.mejs-controls' ).attr( 'style', $( '.mejs-controls' ).attr( 'style' ) + '; background: ' + to + ' !important' );
      $( '.mejs-mediaelement' ).attr( 'style', $( '.mejs-mediaelement' ).attr( 'style' ) + '; background: ' + to + ' !important' );
    } );
  } );

  wp.customize( 'media_player_styles[border]', function( value ) {
    value.bind( function( to ) {
      $( '.mejs-container' ).attr( 'style', $( '.mejs-container' ).attr( 'style' ) + '; border: 1px solid ' + to + ' !important' );
    } );
  } );

  wp.customize( 'media_player_styles[text_color]', function( value ) {
    value.bind( function( to ) {
      $( '.mejs-container .mejs-time .mejs-currenttime' ).attr( 'style', $( '.mejs-container .mejs-time .mejs-currenttime' ).attr( 'style' ) + '; color: ' + to + ' !important' );
      $( '.mejs-container .mejs-time .mejs-duration' ).attr( 'style', $( '.mejs-container .mejs-time .mejs-duration' ).attr( 'style' ) + '; color: ' + to + ' !important' );
    } );
  } );

  wp.customize( 'media_player_styles[button_color]', function( value ) {
    value.bind( function( to ) {
      $( '.mejs-controls .mejs-play button' ).attr( 'style', $( '.mejs-controls .mejs-play button' ).attr( 'style' ) + '; color: ' + to + ' !important' );
      $( '.mejs-controls .mejs-pause button' ).attr( 'style', $( '.mejs-controls .mejs-pause button' ).attr( 'style' ) + '; color: ' + to + ' !important' );
      $( '.mejs-controls .mejs-fullscreen-button button' ).attr( 'style', $( '.mejs-controls .mejs-fullscreen-button button' ).attr( 'style' ) + '; color: ' + to + ' !important' );
      $( '.mejs-controls .mejs-mute button' ).attr( 'style', $( '.mejs-controls .mejs-mute button' ).attr( 'style' ) + '; color: ' + to + ' !important' );
      $( '.mejs-controls .mejs-unmute button' ).attr( 'style', $( '.mejs-controls .mejs-unmute button' ).attr( 'style' ) + '; color: ' + to + ' !important' );
    } );
  } );

  wp.customize( 'media_player_styles[progress_bar_background]', function( value ) {
    value.bind( function( to ) {
      $( '.mejs-controls .mejs-time-rail .mejs-time-total' ).attr( 'style', $( '.mejs-controls .mejs-time-rail .mejs-time-total' ).attr( 'style' ) + '; background: ' + to + ' !important' );
    } );
  } );

  wp.customize( 'media_player_styles[current_progress_bar]', function( value ) {
    value.bind( function( to ) {
      $( '.mejs-controls .mejs-time-rail .mejs-time-current' ).attr( 'style', $( '.mejs-controls .mejs-time-rail .mejs-time-current' ).attr( 'style' ) + '; background: ' + to + ' !important' );
    } );
  } );

  wp.customize( 'media_player_styles[loading_progress_bar]', function( value ) {
    value.bind( function( to ) {
      $( '.mejs-controls .mejs-time-rail .mejs-time-loaded' ).attr( 'style', $( '.mejs-controls .mejs-time-rail .mejs-time-loaded' ).attr( 'style' ) + '; background: ' + to + ' !important' );
    } );
  } );

  wp.customize( 'media_player_styles[volume_bar_background]', function( value ) {
    value.bind( function( to ) {
      $( '.mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-total' ).attr( 'style', $( '.mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-total' ).attr( 'style' ) + '; background: ' + to + ' !important' );
    } );
  } );

  wp.customize( 'media_player_styles[current_volume_bar]', function( value ) {
    value.bind( function( to ) {
      $( '.mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current' ).attr( 'style', $( '.mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current' ).attr( 'style' ) + '; background: ' + to + ' !important' );
    } );
  } );

} )( jQuery );