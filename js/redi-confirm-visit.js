function handleReservationClick(action, successForm) {
    return async (event) => {
      event.preventDefault(); // Prevent default form submission
      
      try {
        const response = await fetchReservationData(action);
        if (response.Error) {
          showError(response.Error);
        } else {
          showSuccess(successForm);
        }
      } catch (error) {
        console.error(error);
      }
    };
  }
  
  async function fetchReservationData(action) {
    const reservationId = jQuery('#redi-reservation-id').val();
    const phone = jQuery('#redi-phone').val();
    const locale = redi_restaurant_reservation.locale;
    const apikeyid = redi_restaurant_reservation.apikeyid;
    const rediNonce = redi_restaurant_reservation.redi_nonce;
  
    const data = {
      action: 'redi_restaurant-submit',
      get: action,
      ID: reservationId,
      Phone: phone,
      lang: locale,
      apikeyid: apikeyid,
      redi_plugin_nonce: rediNonce
    };
  
    jQuery('#visit-load').show();
    jQuery('#redi-confirm-visit-buttons').hide();
  
    const response = await jQuery.post(redi_restaurant_reservation.ajaxurl, data, 'json');
  
    jQuery('#redi-restaurant-cancel').attr('disabled', false);
    jQuery('#visit-load').hide();
  
    return JSON.parse(response);
  }
  
  function showError(errorMessage) {
    jQuery('#confirm-errors').html(errorMessage).show('slow');
  }
  
  function showSuccess(successElementId) {
    jQuery(successElementId).show();
  }

jQuery('#redi-restaurant-confirm-visit').on('click', handleReservationClick('confirm-visit', '#confirm-success'));
jQuery('#redi-restaurant-visit-cancel').on('click', handleReservationClick('cancel-visit', '#cancel-success'));
