function addSpace(n) {
    var rx = /(\d+)(\d{3})/;
    return String(n).replace(/^\d+/, function (w) {
        while (rx.test(w)) {
            w = w.replace(rx, '$1 $2');
        }
        return w;
    });
}



function resetDatepickerToCurrentMonth() {
    var currentDate = new Date();
    jQuery('#redi-restaurant-startDate').datepicker('setDate', currentDate); // Set date to current date
    jQuery('#redi-restaurant-startDate').datepicker('refresh'); // Refresh the datepicker

    // Clear the selected date (if any)
    jQuery('#redi-restaurant-startDate').val('');
}

function toggleWaitList() {
    var today = new Date();
    today.setHours(0);
    today.setMinutes(0);
    today.setSeconds(0);

    var startDate = jQuery('#redi-restaurant-startDate');

    if (Date.parse(today) == Date.parse(startDate.datepicker('getDate'))) {
        jQuery('[name="message-waitlist-form"]').hide();
    }
    else {
        jQuery('[name="message-waitlist-form"]').show();
    }
}

var date_information = [];
var calendarDateFrom;
var calendarDateTo;

var calendarInitiated = false;

jQuery(function () {

    function getTimeByDate() {
        var startDate = jQuery('#redi-restaurant-startDate');
        var day1 = startDate.datepicker('getDate').getDate();
        var month1 = startDate.datepicker('getDate').getMonth() + 1;
        var year1 = startDate.datepicker('getDate').getFullYear();
        var fullDate = year1 + '-' + zeroFill(month1) + '-' + zeroFill(day1);
        if (timeshiftmode === 'byshifts') {
            step1call(fullDate)
        } else {
            hideSteps();
            jQuery('#redi-restaurant-startDateISO').val(fullDate);
            step1call();
        }
        updatePersons();
        toggleWaitList();
    }

    jQuery('#step1button').show();

    jQuery('.disabled').on('click', function (e) {
        e.preventDefault();
    });

    jQuery('#notyou').on('click', function (event) {
        event.preventDefault();
        jQuery('#returned_user').hide();
        jQuery('#name_phone_email_form').show();
    });


    jQuery('.redi-restaurant-duration-button').on('click', function (e) {

        jQuery("#duration").val(this.value);

        jQuery('.redi-restaurant-duration-button').each(function () {
            jQuery(this).removeAttr('select');
        });

        jQuery(this).attr('select', 'select');

        jQuery('#step1button').attr('disabled', false);

        if (jQuery('#redi-restaurant-startDate').datepicker('getDate') == null) {
            return false;
        }

        var day1 = jQuery('#redi-restaurant-startDate').datepicker('getDate').getDate();
        var month1 = jQuery('#redi-restaurant-startDate').datepicker('getDate').getMonth() + 1;
        var year1 = jQuery('#redi-restaurant-startDate').datepicker('getDate').getFullYear();
        var fullDate = year1 + '-' + zeroFill(month1) + '-' + zeroFill(day1)

        if (timeshiftmode === 'byshifts') {
            step1call(fullDate)
        } else {
            hideSteps();
        }

        return false;
    });

    updatePersons();

    function hideSteps() {
        jQuery('#step2').hide('slow'); // if user clicks again first button we hide the other steps
        jQuery('#step3').hide('slow');
        jQuery('#step2busy').hide('slow');

        if (hidesteps) {
            jQuery('#step1busy').hide();
        }
    }

    function updatePersons() {
        //maxPersonsOverride
        if (typeof maxPersonsOverride === 'function') {
            maxPersonsOverride();
        }
    }

    var updateTime = function () {
        if (timepicker == 'dropdown') {

            jQuery('#redi-restaurant-startTime-alt').val(jQuery('#redi-restaurant-startHour').val() + ':' + jQuery('#redi-restaurant-startMinute').val()); // update time in hidden field
            updatePersons();
        }
        hideSteps();
    };

    if (timepicker == 'dropdown') {
        jQuery('#redi-restaurant-startTime-alt').val(jQuery('#redi-restaurant-startHour').val() + ':' + jQuery('#redi-restaurant-startMinute').val()); // update time in hidden field
    }


    jQuery('#redi-restaurant-startHour').change(updateTime);
    jQuery('#redi-restaurant-startMinute').change(updateTime);
    jQuery('#persons, #children').change(function () {


        // show large group message
        if (jQuery(this).val() === 'group' || jQuery('#persons').val() === '0') {
            jQuery('#step1button').attr('disabled', true);
            jQuery('#redi-date-block').hide();
            jQuery("#step2busy").hide();
            if (jQuery(this).val() === 'group') {
                jQuery('#large_groups_message').show('slow');
            }
            else {
                jQuery('#large_groups_message').hide();
            }

            jQuery('#step1buttons').hide('slow');
            jQuery('#message-waitlist-form').hide('slow');

            if (!hidesteps) {
                jQuery('#step2').hide();
            }
        } else 
        // load calendar information
        {
            jQuery('#large_groups_message').hide();

            if (calendarInitiated) {
                // if calendar first time navigated, then load available dates
                loadDateInformation(calendarDateFrom, calendarDateTo);
            }
            else {
                // navigate to first available month
                showFirstAvailableMonthAndSelectDay();
            }
        }
    });

    if (jQuery.datepicker.regional[datepicker_locale] !== undefined) {
        jQuery.datepicker.setDefaults(jQuery.datepicker.regional[datepicker_locale]);
    } else {
        jQuery.datepicker.setDefaults(jQuery.datepicker.regional['']);
    }

    if (jQuery.datepicker.regional[datepicker_locale] !== undefined) {
        jQuery.datepicker.setDefaults(jQuery.datepicker.regional[datepicker_locale.substring(0, 2)]);
    } else {
        jQuery.datepicker.setDefaults(jQuery.datepicker.regional['']);
    }

    jQuery('#redi-restaurant-startTime').datepicker({
        stepMinute: 15,
        timeFormat: timepicker_time_format,
        onClose: function () {
            hideSteps();
            updatePersons();
        },
        altField: '#redi-restaurant-startTime-alt',
        altFieldTimeOnly: false,
        altTimeFormat: 'HH:mm'
    });

    jQuery('#redi-restaurant-startDate').change(function () {
        var day1 = jQuery('#redi-restaurant-startDate').datepicker('getDate').getDate();
        var month1 = jQuery('#redi-restaurant-startDate').datepicker('getDate').getMonth() + 1;
        var year1 = jQuery('#redi-restaurant-startDate').datepicker('getDate').getFullYear();

        jQuery('#redi-restaurant-startDateISO').val(year1 + '-' + zeroFill(month1) + '-' + zeroFill(day1));
    });

    var startDateISO = new Date(jQuery('#redi-restaurant-startDateISO').val());

    // Calendar can shows past month and next month, load 3 month of data
    calendarDateFrom = moment(startDateISO).set('date', 1).add(-1, 'M');
    calendarDateTo = calendarDateFrom.clone().add(3, 'M');

    jQuery('#redi-restaurant-startDate').datepicker({
        beforeShowDay: function (date) {
            let d = jQuery.datepicker.formatDate('yy-mm-dd', date);

            var placeId = jQuery('#placeID').val();
            var guests = parseInt(jQuery('#persons').val()) + (jQuery('#children').val() === undefined ? 0 : parseInt(jQuery('#children').val()));

            var month_info = date_information.find(o =>
                o.month === jQuery.datepicker.formatDate('yy-mm', date)
                && o.placeId == placeId
                && o.guests == guests);

            if (month_info == null) {
                return [true, '', ''];
            }

            var date_info = month_info.data.find(o => o.Date === d);

            if (date_info == null)
                return [true, '', ''];

            if (!date_info.Open)
                return [false, '', date_info.Reason];

            if (date_info.Blocked)
                return [false, '', date_info.Reason];

            if (date_info.FullyBooked)
                return [true, 'redi_calendar_fully_booked', date_info.Reason];

            return [true, '', ''];
        },
        onChangeMonthYear: function (year, month) {
            jQuery('#redi-restaurant-startDate').val('');
            jQuery('#step2').hide();

            calendarDateFrom = moment({ year, month: month - 1, day: 1 });
            calendarDateTo = moment({ year, month: month - 1, day: 1 });
            calendarDateTo.add(1, 'M');

            loadDateInformation(calendarDateFrom, calendarDateTo);
        },
        dateFormat: date_format,
        minDate: new Date(),
        maxDate: maxDate,
        onSelect: function () {
            if (timeshiftmode === 'byshifts') {
                jQuery('#ui-datepicker-div').hide();
                getTimeByDate();
            }
        }
    });

    jQuery('.ui-datepicker-current-day').removeClass('ui-datepicker-current-day');

    // Reset the current selected day
    jQuery('#redi-restaurant-startDate').val('');

    jQuery('#redi-popup-close').click(function() {
        jQuery('#redi-popup-dialog').hide();
        return false;
    });

    // Close the popup if user clicks outside of the popup content
    jQuery(window).click(function(event) {
        if (jQuery(event.target).is('#redi-popup-dialog')) {
            jQuery('#redi-popup-dialog').hide();
            return false;
        }
    });

    jQuery(document).on('click', '.redi-restaurant-time-button', function () {

        if (jQuery(this).hasClass('disabled'))
        {
            var popupText = jQuery(this).data("tooltip");
            jQuery('#redi-popup-text').text(popupText); // Fallback text

            // Show the popup dialog
            jQuery('#redi-popup-dialog').show();

            return false;
        }


        jQuery('.redi-restaurant-time-button').each(function () {
            jQuery(this).removeAttr('select');
        });

        jQuery(".services-left").hide();

        jQuery(this).attr('select', 'select');

        jQuery('#redi-restaurant-startTimeHidden').val(jQuery(this).val());
        jQuery('#redi-restaurant-duration').val(jQuery(this).data('reservation-duration'));

        if (displayLeftSeats) {
            var left = jQuery(this).parent().find(".services-left");
            left.html(redi_restaurant_reservation.available_seats + ': ' + jQuery(this).data('time-services-left'));
            left.toggle();
        }

        getCustomFields();

        if (hidesteps) {
            jQuery('#step2').hide();
            jQuery('#step3').show();
        } else {
            jQuery('#step3').show('slow');
        }
        jQuery('#UserName').focus();
        jQuery('#step3errors').hide();

        return false;
    });
    jQuery(document).on('click', '#redi-restaurant-step3', function () {
        var error = '';
        if (jQuery('#UserName').val() === '') {
            if (jQuery('#UserLastName').length)
                error += redi_restaurant_reservation.fname_missing + '<br/>';
            else
                error += redi_restaurant_reservation.name_missing + '<br/>';
        }
        if (jQuery('#UserLastName').val() === '') {
            error += redi_restaurant_reservation.lname_missing + '<br/>';
        }
        if (jQuery('#UserEmail').val() === '') {
            error += redi_restaurant_reservation.email_missing + '<br/>';
        }

        if (itiUserPhone !== undefined) {
            if (itiUserPhone.getNumber() === '') {
                error += redi_restaurant_reservation.phone_missing + '<br/>';
            }
            else if (!validatePhone(itiUserPhone.getNumber())) {
                error += redi_restaurant_reservation.phone_not_valid + '<br/>';
            }
        }
        else {
            if (jQuery('#UserPhone').val() === '') {
                error += redi_restaurant_reservation.phone_missing + '<br/>';
            }
            else if (!validatePhone(jQuery('#UserPhone').val())) {
                error += redi_restaurant_reservation.phone_not_valid + '<br/>';
            }
        }

        if (jQuery('#redi-captcha').length && !document.querySelector('.g-recaptcha-response').value) {
            error += redi_restaurant_reservation.captcha_not_valid + '<br/>';
        }

        let radio_error = 1;
        jQuery('.field_required').each(function () {
            if (jQuery(this).attr('type')) {
                if (jQuery(this).attr('type') === 'checkbox' && !jQuery(this).is(':checked') || jQuery(this).attr('type') === 'text' && jQuery(this).val() === '') {
                    error += jQuery('#' + this.id + '_message').attr('value') + '<br/>';
                }

                if (jQuery(this).attr('type') === 'radio' && radio_error) {
                    if (!jQuery('input[type="radio"]:checked').val()) {
                        error += jQuery('#' + jQuery(this).attr('name') + '_message').attr('value') + '<br/>';
                        radio_error--;
                    }
                }
            } else {
                if (!jQuery(this).val()) {
                    error += jQuery('#' + this.id + '_message').attr('value') + '<br/>';
                }
            }
        });

        if (error) {
            jQuery('#step3errors').html(error).show('slow');
            return false;
        }
        var data = {
            action: 'redi_restaurant-submit',
            get: 'step3',
            startDate: jQuery('#redi-restaurant-startDate').val(),
            startTime: jQuery('#redi-restaurant-startTimeHidden').val(),
            persons: jQuery('#persons').val(),
            children: jQuery('#children').val(),
            UserName: jQuery('#UserName').val(),
            UserLastName: jQuery('#UserLastName').val(),
            UserEmail: jQuery('#UserEmail').val(),
            UserComments: jQuery('#UserComments').val(),
            UserPhone: jQuery('#UserPhone').val(),
            placeID: jQuery('#placeID').val(),
            lang: locale,
            duration: jQuery('#redi-restaurant-duration').val(),
            apikeyid: apikeyid,
        };

        var custom_fields = jQuery("[name^='field_']");

        for (var index = 0; index < custom_fields.length; ++index) {

            if (jQuery(custom_fields[index]).attr('type') === 'checkbox') {

                if (jQuery(custom_fields[index]).is(':checked')) {
                    data[custom_fields[index].id] = 'on';
                }
            } else if (jQuery(custom_fields[index]).attr('type') === 'radio') {

                if (jQuery(custom_fields[index]).is(':checked')) {
                    data[jQuery(custom_fields[index]).attr('name')] = jQuery(custom_fields[index]).val();
                }
            } else {
                data[custom_fields[index].id] = jQuery(custom_fields[index]).val();
            }
        }

        jQuery('#step3load').show();
        jQuery('#step3errors').hide('slow');
        jQuery('#redi-restaurant-step3').attr('disabled', true);
        jQuery.post(redi_restaurant_reservation.ajaxurl, data, function (response) {
            jQuery('#redi-restaurant-step3').attr('disabled', false);
            jQuery('#step3load').hide();

            if (response.hasOwnProperty('Error') || !response.hasOwnProperty('ID')) {

                if (response.hasOwnProperty('Error')) {
                    jQuery('#step3errors').html(response['Error']).show('slow');
                }
                else {
                    var emailLink = '<a target="_blank" href="mailto:info@reservationdiary.eu">info@reservationdiary.eu</a>';
                    var errorMessage = redi_restaurant_reservation.unexpected_error;
                    errorMessage = errorMessage.replace('{emailLink}', emailLink);

                    jQuery('#step3errors').html(errorMessage + " " + response).show('slow');
                }
            } else {
                ga_event('Reservation confirmed', '');

                // redirect to new page is specified
                if (redirect_to_confirmation_page.length > 0) {
                    jQuery(location).attr('href', redirect_to_confirmation_page + "?reservation_id=" + addSpace(response['ID']));
                }
                else {
                    // show confirmation block
                    jQuery('#step1').hide('slow');
                    jQuery('#step2').hide('slow');
                    jQuery('#step3').hide('slow');
                    jQuery('#social').hide('slow');
                    jQuery('#step4').show('slow'); //success message
                    jQuery('#reservation-id').html(addSpace(response['ID']));
                    jQuery('html, body').animate({ scrollTop: jQuery("#redi-reservation").offset().top }, 'slow');
                    jQuery('.userfeedback').show('slow'); // Feedbackd form
                }
            }
        }, 'json')
            .error(function (xhr) {
                jQuery('#step3errors').html(xhr.responseText).show('slow');
            });
        return false;
    });
    jQuery(document).on('click', '#step1button', function () {
        if (timeshiftmode === 'byshifts') {
            step1call();
        } else {
            jQuery('#step1button').attr('disabled', true);
            var start_date = jQuery('#redi-restaurant-startDate').datepicker('getDate');
            if (start_date !== null) {
                var day1 = start_date.getDate();
                var month1 = start_date.getMonth() + 1;
                var year1 = start_date.getFullYear();
                var fullDate = year1 + '-' + month1 + '-' + day1;
                step1call(fullDate);
            } else {
                jQuery('#redi-restaurant-startDate').addClass('redi-invalid');
            }
            jQuery('#step1button').attr('disabled', false);
        }
        return false;
    });

    jQuery('#placeID').change(function () {

        jQuery('#duration').val(this.options[this.selectedIndex].getAttribute('data-duration'));
        jQuery('#redi-date-block').hide();

        calendarInitiated = false;
        resetDatepickerToCurrentMonth();

        showFirstAvailableMonthAndSelectDay();

        if (hidesteps) {
            jQuery('#step1buttons').hide('slow');
        }

        jQuery('#step2').hide('slow'); // if user clicks again first button we hide the other steps
        jQuery('#step3').hide('slow');
        jQuery('#step1errors').hide('slow');
    });



    function loadDateInformation(from, to) {
        var placeId = jQuery('#placeID').val();
        var guests = parseInt(jQuery('#persons').val()) + (jQuery('#children').val() === undefined ? 0 : parseInt(jQuery('#children').val()));

        if (!calendarInitiated) {
            return false;
        }

        if (guests == 0 || placeId == 0) {
            return;
        }

        console.log('Loading dates from: ', calendarDateFrom, ' to:', calendarDateTo);

        if (date_information.find(o =>
            o.month === from.format('YYYY-MM')
            && o.placeId == placeId
            && o.guests == guests) == null) {
            var isDatapickerOpen = jQuery('#ui-datepicker-div').css('display');

            jQuery('#redi-restaurant-startDate').hide();
            jQuery('#ui-datepicker-div').hide();
            jQuery('#step1errors').hide();
            jQuery('#date_info_load').show();
            jQuery('#date_info_load').focus();

            var data = {
                action: 'redi_restaurant-submit',
                get: 'date_information',
                from: from.format('YYYY-MM-DD'),
                to: to.format('YYYY-MM-DD'),
                placeID: placeId,
                apikeyid: apikeyid,
                guests: guests,
            };

            jQuery.post(redi_restaurant_reservation.ajaxurl, data, function (response) {

                response = JSON.parse(response);

                if (response['Error'] !== undefined) {
                    jQuery('#step1errors').html(response['Error']).show('slow');
                    jQuery('#date_info_load').hide();
                }
                else {
                    var fromDate = from.clone();

                    while (fromDate < to) {
                        var dates = response.filter(item => item.Date.indexOf(fromDate.format('YYYY-MM')) > -1)

                        date_information.push(
                            {
                                month: fromDate.format('YYYY-MM'),
                                data: dates,
                                placeId: placeId,
                                guests: guests
                            }
                        );

                        fromDate.add(1, 'M');
                    }

                    jQuery('#date_info_load').hide();
                    jQuery('#redi-restaurant-startDate').datepicker("refresh");
                    jQuery('#redi-restaurant-startDate').show();

                    if (isDatapickerOpen == 'block') {
                        jQuery('#ui-datepicker-div').show();
                    }
                }
            });
        }



        jQuery('#redi-date-block').show();
    }

    function step1call(fullDate) {
        if (jQuery('#persons').val() === 'group' || jQuery('#persons').val() === '0') return;
        hideSteps();

        jQuery('#redi-restaurant-startDateISO').val(fullDate);
        jQuery('#step2').hide('slow'); // if user clicks again first button we hide the other steps
        jQuery('#step3').hide('slow');
        jQuery('#step1load').show();
        jQuery('#step1errors').hide('slow');
        jQuery('#message-waitlist-form').hide('slow');
        jQuery('#step1times').hide();
        jQuery('#all_busy_error').hide();
        var data = {
            action: 'redi_restaurant-submit',
            get: 'step1',
            placeID: jQuery('#placeID').val(),
            startTime: jQuery('#redi-restaurant-startTime-alt').val(),
            startDateISO: jQuery('#redi-restaurant-startDateISO').val(),
            duration: jQuery("#duration").val(),
            persons: +jQuery('#persons').val() + (jQuery('#children').val() ? +jQuery('#children').val() : 0),
            lang: locale,
            timeshiftmode: timeshiftmode,
            apikeyid: apikeyid,
        };

        jQuery.post(redi_restaurant_reservation.ajaxurl, data, function (response) {
            jQuery('#step1load').hide();
            jQuery('#buttons').html('');

            if (response['Error'] !== undefined) {
                if (waitlist == 1) {
                    jQuery('#step2busy').show();
                }
                else {
                    jQuery('#step1errors').html(response['Error']).show('slow');
                }
            } else if (response["all_booked_for_this_duration"]) {
                jQuery('#step1errors').html(redi_restaurant_reservation.error_fully_booked).show('slow');
            } else {
                if (hidesteps) {
                    jQuery('#step1times').show();
                }

                if (response['alternativeTime'] !== undefined) {

                    jQuery("#time2label").show();

                    switch (response['alternativeTime']) {
                        case 1: //AlternativeTimeBlocks see class AlternativeTime::
                        //pass thought
                        case 2: //AlternativeTimeByShiftStartTime

                            var all_busy = true;
                            for (var res in response) {
                                if (response[res] !== undefined) {

                                    jQuery('#buttons').append(
                                        '<button ' + (response[res]['Available'] ? '' : 'title="' + redi_restaurant_reservation.tooltip + '"') +
                                        ' class="redi-restaurant-time-button button ' + (response[res]['Available'] ? '' : 'disabled') +
                                        ' ' + response[res]['DiscountClass'] +
                                        '" value="' + response[res]['StartTimeISO'] + '" ' +
                                        ' ' + (response[res]['Select'] ? 'select="select"' : '') +
                                        '>' + (response[res]['Discount'] == undefined ? '' : response[res]['Discount'] + '<br/>') +
                                        response[res]['StartTime'] + '</button>'
                                    );
                                }
                                if (response[res]['Available']) all_busy = false;
                            }
                            display_all_busy(all_busy);
                            break;
                        case 3: //AlternativeTimeByDay
                            var all_busy = true;
                            var current = 0;
                            var step1buttons_html = '';
                            jQuery('#step1buttons_html').html(step1buttons_html).hide();

                            for (var availability in response) {

                                if (response[availability]['Name'] !== undefined) {
                                    var html = '<div>';

                                    if (!hidesteps) {
                                        if (response[availability]['Name']) {
                                            html += response[availability]['Name'] + ':</br>';
                                        }
                                    }

                                    if (hidesteps) {
                                        if (response[availability]['Name'] === null) {
                                            response[availability]['Name'] = redi_restaurant_reservation.next;
                                        }
                                        step1buttons_html += '<input id="time_' + (current) + '" value="' + response[availability]['Name'] + '" class="redi-restaurant-button button ';
                                        html += '<span class="opentime" id="opentime_' + (current) + '" style="display: none">';
                                    }
                                    var current_button_busy = true;
                                    for (var current_button_index in response[availability]['Availability']) {

                                        var b = response[availability]['Availability'][current_button_index];
                                        var dispalytime =
                                            (b['Discount'] == undefined ? '' : b['Discount'] + '<br/>') +
                                            b['StartTime'] +
                                            (redi_restaurant_reservation.endreservationtime == 'true' ? ' - ' + b['EndTime'] : '');

                                        var duration = b['Duration'];

                                        html += '<button ' +
                                            'data-reservation-duration="' + duration + '"' +
                                            'data-time-services-left="' + b['ServicesLeft'] + '"' +
                                            //+ (b['Available'] ? '' : 'disabled="disabled"')
                                            (b['Available'] ? '' : ' data-tooltip="' + b['Reason'] + '"') +
                                            ' class="redi-restaurant-time-button button ' + (b['Available'] ? '' : 'disabled') +
                                            ' ' + (b['DiscountClass'] ? b['DiscountClass'] : '') +
                                            '" value="' + b['StartTimeISO'] + '" ' +
                                            ' ' + (b['Select'] ? 'select="select"' : '') + '>'
                                            + dispalytime + '</button>';
                                        if (b['Available']) {
                                            all_busy = false;
                                            current_button_busy = false;
                                        }
                                    }

                                    if (current_button_busy) {
                                        let step2busyClone = jQuery('#step2busy').clone();
                                        if (!step2busyClone.hasClass('not-waitlist')) {
                                            step2busyClone.removeAttr('id');
                                            step2busyClone.css("display", "block");
                                            html += step2busyClone.get(0).outerHTML;
                                        }
                                    }

                                    html += '<br clear="all"><div class="services-left"></div></div>';

                                    html += '<br clear="all">';
                                    if (hidesteps) {
                                        html += '</span>';
                                    }

                                    jQuery('#buttons').append(html);
                                    if (hidesteps) {
                                        if (current_button_busy) {
                                            step1buttons_html += 'disabled"'; //add class
                                            step1buttons_html += ' title="' + redi_restaurant_reservation.tooltip + '"';
                                        } else {
                                            step1buttons_html += 'available"'; //close class bracket
                                        }
                                        step1buttons_html += ' type="submit">';
                                    }
                                }
                                current++;
                            }
                            jQuery('#buttons').append('</br>');
                            if (jQuery('#persons').val() === 'group' || jQuery('#persons').val() === '0') {
                                jQuery('#step1button').attr('disabled', true);

                                if (jQuery('#persons').val() === 'group') {
                                    jQuery('#large_groups_message').show('slow');
                                }
                                else {
                                    jQuery('#large_groups_message').hide();
                                }

                                jQuery('#step1buttons').hide('slow');
                                jQuery('#message-waitlist-form').hide('slow');

                                if (!hidesteps) {
                                    jQuery('#step2').hide();
                                }
                            } else {
                                jQuery('#step1buttons').html(step1buttons_html).show();
                                display_all_busy(all_busy);
                            }
                            break;
                    }
                } else {
                    for (res in response) {
                        var dispalytime = redi_restaurant_reservation.endreservationtime == 'true' ? response[res]['StartTime'] + ' - ' + response[res]['EndTime'] : response[res]['StartTime'];
                        var duration = response[res]['Duration'];

                        jQuery('#buttons').append(
                            '<button class="redi-restaurant-button redi-restaurant-time-button normal" value="' +
                            response[res]['StartTimeISO'] + '" ' +
                            'data-reservation-duration="' + duration + '"' +
                            (response[res]['Available'] ? '' : 'disabled="disabled"') +
                            ' ' + (response[res]['Select'] ? 'select="select"' : '') +
                            '>' + dispalytime + '</button>'
                        );
                    }
                }


                jQuery('#redi-restaurant-startTimeHidden').val(response['StartTimeISO']);
                if (!hidesteps) {
                    jQuery('#step2').show('slow');
                    // if selected time is available make it bold and show fields
                    jQuery('.redi-restaurant-time-button').each(function () {
                        if (jQuery(this).attr('select')) {
                            jQuery(this).click();
                        }
                    });
                }

                jQuery('#UserName').focus();
            }

            jQuery('.link-waitlist-form').off("click");
            jQuery('.link-waitlist-form').click(function () {
                clickWaitListForm();
            });
        }, 'json');
    }

    function display_all_busy(hide) {
        jQuery('.redi-restaurant-button').tooltip();
        jQuery('.redi-restaurant-time-button').tooltip();
        if (hide) {
            jQuery('#step1times').hide();
            if (hidesteps) {
                jQuery('#step1busy').show();
            } else {
                jQuery('#buttons').hide();
                jQuery('#step2busy').show();
            }
        } else {
            jQuery('#step2busy').hide();
            jQuery('#step1times').show();
            if (hidesteps) {
                jQuery('#step1busy').hide();
            } else {
                jQuery('#buttons').show();
                jQuery('#step2busy').hide();
            }
        }


    }

    function ga_event(event, comment) {
        if (typeof _gaq !== 'undefined') {
            _gaq.push(['_trackEvent', 'ReDi Restaurant Reservation', event, comment]);
        }
    }



    function clickWaitListForm() {
        jQuery('#redi-reservation').toggle("slide");
        jQuery('#step2busy').hide();
        jQuery('#step1errors').hide();
        jQuery('.waitlist-form').toggle("slide");
        var valueDate = jQuery('#redi-restaurant-startDate').val();
        jQuery('#redi-waitlist-startDate').val(jQuery('#redi-restaurant-startDateISO').val());
        jQuery('#waitlist-startDate-label').html(valueDate);
        var valuePersons = jQuery('#persons').val();
        jQuery('#waitlist-persons-label').html(valuePersons);
        jQuery('#waitlist-persons').val(valuePersons);
    }

    function getCustomFields() {

        jQuery('#RediCustomFields').show();

        var data = {
            action: 'redi_restaurant-submit',
            get: 'get_custom_fields',
            placeID: jQuery('#placeID').val(),
            lang: locale,
            apikeyid: apikeyid,
        };

        jQuery.post(redi_restaurant_reservation.ajaxurl, data, function (response) {
            jQuery('#custom_fields_container').html(JSON.parse(response))
            jQuery('#RediCustomFields').hide();
        });
    }

    //Cancel reservation
    jQuery(document).on('click', '#cancel-reservation', function () {
        jQuery('#redi-reservation').slideUp();
        jQuery('#cancel-reservation-div').slideDown();
    });

    //Modify reservation
    jQuery(document).on('click', '#modify-reservation', function () {
        jQuery('#redi-reservation').slideUp();
        jQuery('#modify-reservation-div').slideDown();
    });

    jQuery(document).on('click', '.back-to-reservation', function () {
        jQuery('#redi-reservation').slideDown();
        jQuery('#cancel-reservation-div').slideUp();
        jQuery('#modify-reservation-div').slideUp();
        jQuery('#update-reservation-div').slideUp();
        jQuery('#cancel-reservation-form').slideDown();
        jQuery('#modify-reservation-form').slideDown();
        jQuery('#cancel-success').slideUp();
    });

    function getParameterByName(name) {
        var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.hash);
        return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
    }

    jQuery(window).on("load", function () {

        if (Object.values(location.hash.split('?')).indexOf('#cancel') > -1) {
            jQuery('#cancel-reservation-div').slideDown();
            jQuery('#redi-reservation').slideUp();
            jQuery('#redi-restaurant-cancelID').val(getParameterByName("reservation"));
            jQuery('#redi-restaurant-cancelEmail').val(getParameterByName("personalInformation"));

            if (jQuery('#redi-restaurant-cancelEmail').val().length > 0) {
                hideUnnecessaryFilledFieldsForCancel();
            }
        }

        if (Object.values(location.hash.split('?')).indexOf('#modify') > -1) {
            jQuery('#modify-reservation-div').slideDown();
            jQuery('#redi-reservation').slideUp();
            jQuery('#redi-restaurant-modifyID').val(getParameterByName("reservation"));
            jQuery('#redi-restaurant-modifyEmail').val(getParameterByName("personalInformation"));
        }

    });

    function hideUnnecessaryFilledFieldsForCancel() {
        jQuery('.redi-restaurant-hideContent input:not(:hidden)').each(function () {
            // Check if the input field's value length is 0
            if (jQuery(this).val().trim().length === 0) {
                // Hide the parent div of the input field
                jQuery(this).closest('.redi-restaurant-hideContent').slideUp();
            }
        });
    }

    var inputIds = ["#cancelPhone-intlTel", "#redi-restaurant-cancelName", "#redi-restaurant-cancelEmail"];
    var inputClasses = [".redi-rest-phone", ".redi-rest-name", ".redi-rest-email"];

    inputIds.forEach(item => {
        jQuery(item).on("keyup", function (event) {
            if (event.key === "Backspace" || event.key === "Delete") {
                if (jQuery(this).val().trim().length < 1) {
                    jQuery(".redi-restaurant-hideContent").slideDown();
                }

            } else {
                hideUnnecessaryFilledFieldsForCancel();
            }
        });
    });

    inputClasses.forEach(item => {
        jQuery(item).on("blur", function () {
            if (jQuery(this).val().trim().split("").length < 1) {
                jQuery(".redi-restaurant-hideContent").slideDown();
            }
        });
    })

    function validatePhone(phone) {
        var re = /^[+]*[(]{0,1}[0-9]{1,3}[)]{0,1}[-\s\./0-9]*$/g
        return re.test(phone);
    }

    function validateTime(time) {
        if (time === '') return true;

        var t = moment(time, ["HH", "hh", "hh A", "HH:mm", "hh:mm", "hh:mm A"]);

        return t.isValid();
    }

    // reservation cancel
    jQuery(document).on('click', '#redi-restaurant-cancel', function () {
        var error = '';

        if (jQuery('#redi-restaurant-cancelID').val() === '') {
            error += redi_restaurant_reservation.id_missing + '<br/>';
        }

        if (jQuery('#redi-restaurant-cancelEmail').val() === '' && jQuery('#redi-restaurant-cancelName').val() === '' && jQuery('#cancelPhone-intlTel').val() === '') {
            error += redi_restaurant_reservation.personalInf + '<br/>';
        } else if (jQuery('#cancelPhone-intlTel').val() !== '' && (itiCancelPhone !== undefined && itiCancelPhone.getValidationError(jQuery('#cancelPhone-intlTel').val()) || !validatePhone(jQuery('#redi-restaurant-cancelPhone').val()))) {
            error += redi_restaurant_reservation.phone_not_valid + '<br/>';
        }

        if (redi_restaurant_reservation.cancel_reason_mandatory == true && jQuery('#redi-restaurant-cancelReason').val() === '') {
            error += redi_restaurant_reservation.reason_missing + '<br/>';
        }

        if (error) {
            jQuery('#cancel-errors').html(error).show('slow');
            return false;
        }
        //Ajax
        var data = {
            action: 'redi_restaurant-submit',
            get: 'cancel',
            ID: jQuery('#redi-restaurant-cancelID').val(),
            Name: jQuery('#redi-restaurant-cancelName').val(),
            Phone: jQuery('#redi-restaurant-cancelPhone').val(),
            Email: jQuery('#redi-restaurant-cancelEmail').val(),
            Reason: jQuery('#redi-restaurant-cancelReason').val(),
            lang: locale,
            apikeyid: apikeyid,
        };
        jQuery('#cancel-errors').slideUp();
        jQuery('#cancel-success').slideUp();
        jQuery('#cancel-load').show();
        jQuery('#redi-restaurant-cancel').attr('disabled', true);
        jQuery.post(redi_restaurant_reservation.ajaxurl, data, function (response) {
            jQuery('#redi-restaurant-cancel').attr('disabled', false);
            jQuery('#cancel-load').hide();
            if (response['Error']) {
                jQuery('#cancel-errors').html(response['Error']).show('slow');
            } else {
                jQuery('#cancel-success').slideDown();
                jQuery('#cancel-errors').slideUp();
                jQuery('#cancel-reservation-form').slideUp();
                jQuery('html, body').animate({ scrollTop: jQuery("#redi-reservation").offset().top }, 'slow');
                //clear form
                jQuery('#redi-restaurant-cancelID').val('');
                jQuery('#redi-restaurant-cancelEmail').val('');
                jQuery('#redi-restaurant-cancelReason').val('');
            }
        }, 'json');
        return false;
    });

    //reservation modify
    jQuery(document).on('click', '#redi-restaurant-modify', function () {
        var error = '';

        if (jQuery('#redi-restaurant-modifyID').val() === '') {
            error += redi_restaurant_reservation.id_missing + '<br/>';
        }

        if (jQuery('#redi-restaurant-modifyEmail').val() === '' && jQuery('#redi-restaurant-modifyName').val() === '' && jQuery('#modifyPhone-intlTel').val() === '') {
            error += redi_restaurant_reservation.personalInf + '<br/>';
        }
        else if (jQuery('#modifyPhone-intlTel').val() !== '' && (itiModifyPhone !== undefined && itiModifyPhone.getValidationError() || !validatePhone(jQuery('#redi-restaurant-modifyPhone').val()))) {

            error += redi_restaurant_reservation.phone_not_valid + '<br/>';
        }

        if (error) {
            jQuery('#modify-errors').html(error).show('slow');
            return false;
        }
        //Ajax
        var data = {
            action: 'redi_restaurant-submit',
            get: 'modify',
            ID: jQuery('#redi-restaurant-modifyID').val(),
            Name: jQuery('#redi-restaurant-modifyName').val(),
            Phone: jQuery('#redi-restaurant-modifyPhone').val(),
            Email: jQuery('#redi-restaurant-modifyEmail').val(),
            lang: locale,
            apikeyid: apikeyid,
        };
        jQuery('#modify-errors').slideUp();
        jQuery('#modify-load').show();
        jQuery('#redi-restaurant-modify').attr('disabled', true);
        jQuery.post(redi_restaurant_reservation.ajaxurl, data, function (response) {
            jQuery('#redi-restaurant-modify').attr('disabled', false);
            jQuery('#modify-load').hide();

            let reservation = response.reservation;

            if (reservation['Error']) {
                jQuery('#modify-errors').html(reservation['Error']).show('slow');
            } else {
                jQuery('#update-success').slideUp();
                jQuery('#modify-reservation-div').slideUp();
                jQuery('#update-reservation-div').slideDown();
                jQuery('#update-reservation-form').slideDown();

                jQuery('#updatePersons').val(reservation['Persons']);
                jQuery('#updateUserName').val(reservation['Name']);
                jQuery('#updateUserEmail').val(reservation['Email']);
                jQuery('#updateUserComments').val(reservation['Comments']);
                jQuery('#redi-restaurant-updateID').val(jQuery('#redi-restaurant-modifyID').val());
                jQuery('#updateTo').val(reservation['To']);
                jQuery('#updateFrom').val(reservation['From']);
                jQuery('#updateDateFrom').text(response.startDate);
                jQuery('#updateTimeFrom').text(response.startTime);
                jQuery('#updatePlaceReferenceId').val(reservation['PlaceReferenceId']);
                jQuery('#updateUserPhone').val(reservation['Phone']);

                if (itiUpdateUserPhone !== undefined) {
                    itiUpdateUserPhone.setNumber(reservation['Phone']);
                }
                else {
                    jQuery('#updateUserPhone-intlTel').val(reservation['Phone']);
                }

                //clear form
                jQuery('#redi-restaurant-modifyID').val('');
                jQuery('#redi-restaurant-modifyEmail').val('');
            }
        }, 'json');
        return false;
    });

    //reservation update
    jQuery(document).on('click', '#redi-restaurant-update', function () {
        var error = '';

        if (jQuery('#updateUserName').val() == '') {
            error += redi_restaurant_reservation.name_missing + '<br/>';
        }
        if (jQuery('#updateUserEmail').val() == '') {
            error += redi_restaurant_reservation.email_missing + '<br/>';
        }


        if (itiUpdateUserPhone !== undefined) {
            if (itiUpdateUserPhone.getNumber() == '') {
                error += redi_restaurant_reservation.phone_missing + '<br/>';
            }
            else if (!validatePhone(itiUpdateUserPhone.getNumber())) {
                error += redi_restaurant_reservation.phone_not_valid + '<br/>';
            }
        }
        else {
            if (jQuery('#updateUserPhone').val() === '') {
                error += redi_restaurant_reservation.phone_missing + '<br/>';
            }
            else if (!validatePhone(jQuery('#updateUserPhone').val())) {
                error += redi_restaurant_reservation.phone_not_valid + '<br/>';
            }
        }

        if (error) {
            jQuery('#update-errors').html(error).show('slow');
            return false;
        }
        //Ajax
        var data = {
            action: 'redi_restaurant-submit',
            get: 'update',
            ID: jQuery('#redi-restaurant-updateID').val(),
            PlaceReferenceId: jQuery('#updatePlaceReferenceId').val(),
            Quantity: jQuery('#updatePersons').val(),
            UserName: jQuery('#updateUserName').val(),
            UserPhone: jQuery('#updateUserPhone').val(),
            UserEmail: jQuery('#updateUserEmail').val(),
            UserComments: jQuery('#updateUserComments').val(),
            StartTime: jQuery('#updateFrom').val(),
            EndTime: jQuery('#updateTo').val(),
            lang: locale,
            apikeyid: apikeyid,
        };

        jQuery('#update-errors').slideUp();
        jQuery('#update-success').slideUp();
        jQuery('#update-load').show();
        jQuery('#redi-restaurant-update').attr('disabled', true);
        jQuery.post(redi_restaurant_reservation.ajaxurl, data, function (response) {
            jQuery('#redi-restaurant-update').attr('disabled', false);
            jQuery('#update-load').hide();

            if (response['Error']) {
                jQuery('#update-errors').html(response['Error']).show('slow');
            } else {
                jQuery('#update-reservation-form').slideUp();
                jQuery('#update-success').slideDown();
                jQuery('html, body').animate({ scrollTop: jQuery("#redi-reservation").offset().top }, 'slow');

                //clear form           
                jQuery('#updatePersons').val('');
                jQuery('#updateDateFrom').text('');
                jQuery('#updateTimeFrom').text('');
                jQuery('#updateUserName').val('');
                jQuery('#updateUserPhone').val('');
                jQuery('#updateUserEmail').val('');
                jQuery('#updateUserComments').val('');
            }
        }, 'json');
        return false;
    });

    jQuery(document).on('click', '.available', function (event) {
        event.preventDefault();
        jQuery('#step1').hide();
        jQuery('#step2').show();
        jQuery('#open' + this.id).show();
    });

    jQuery(document).on('click', '.disabled', function (event) {
        event.preventDefault();
    });

    jQuery(document).on('click', '#step2prev', function (event) {
        event.preventDefault();
        jQuery('#step1').show();
        jQuery('#step2').hide();
        jQuery('.opentime').each(function () {
            jQuery(this).hide();
        });
    });

    jQuery(document).on('click', '#step3prev', function (event) {
        event.preventDefault();
        jQuery('#step3').hide();
        jQuery('#step2').show();
    });

    jQuery(document).on('click', '#redi-waitlist-submit', function () {

        var error = '';

        if (!validateTime(jQuery('#waitlist-Time').val())) {
            error += redi_restaurant_reservation.time_not_valid + '<br/>';
        }

        if (jQuery('#waitlist-UserName').val() === '') {
            error += redi_restaurant_reservation.name_missing + '<br/>';
        }

        if (jQuery('#waitlist-UserEmail').val() === '') {
            error += redi_restaurant_reservation.email_missing + '<br/>';
        }

        if (waitlist_itiUserPhone !== undefined) {
            if (waitlist_itiUserPhone.getNumber() === '') {
                error += redi_restaurant_reservation.phone_missing + '<br/>';
            }
            else if (!validatePhone(waitlist_itiUserPhone.getNumber())) {
                error += redi_restaurant_reservation.phone_not_valid + '<br/>';
            }
        }
        else {

            if (jQuery('#waitlist-UserPhone').val() === '') {
                error += redi_restaurant_reservation.phone_missing + '<br/>';
            }
            else if (!validatePhone(jQuery('#waitlist-UserPhone').val())) {
                error += redi_restaurant_reservation.phone_not_valid + '<br/>';
            }
        }

        jQuery('.waitlist_field_required').each(function () {
            if (jQuery(this).attr('type') === 'checkbox' && !jQuery(this).is(':checked')) {
                error += jQuery('#' + this.id + '_message').attr('value') + '<br/>';
            }
        });

        if (error) {
            jQuery('#waitlistload').hide('slow');
            jQuery('#wait-list-error').html(error).show('slow');
            return false;
        }

        jQuery('#waitlistload').show();
        jQuery('#wait-list-error').html(error).hide('slow');

        var data = {
            action: 'redi_waitlist-submit',
            get: 'waitlist',
            'Date': jQuery('#redi-waitlist-startDate').val(),
            'Guests': jQuery('#waitlist-persons').val(),
            'Name': jQuery('#waitlist-UserName').val(),
            'Email': jQuery('#waitlist-UserEmail').val(),
            'Phone': jQuery('#waitlist-UserPhone').val(),
            'placeID': jQuery('#waitlist-placeID').val(),
            'Time': jQuery('#waitlist-Time').val(),
        };

        jQuery.post(redi_restaurant_reservation.ajaxurl, data, function (response, success) {
            jQuery('#waitlistload').hide('slow');
        }, 'json').done(function (data, statusText, xhr) {
            var status = xhr.status;
            var head = xhr.responseJSON['Error'];
            if (status == 200) {
                if (data['Error']) {
                    jQuery('#wait-list-error').html(head).show('slow');
                }
                else {
                    jQuery('#wait-list-error').hide('slow');
                    jQuery('#redi-waitlist-form').hide('slow');
                    jQuery('#wait-list-success').show('slow');
                }
            }
            if (status == 500) {
                var Error = 'Wait List does not work at the moment, please try again later or contact restaurant directly.';
                jQuery('#wait-list-error').html(Error).show('slow');
            }
            if (status == 400) {
                jQuery('#wait-list-error').html(head).show('slow');
            }
        });

        return false;
    });

    function get_tel_input(val) {
        let itiPhone = window.intlTelInput(val, {
            // separateDialCode: true,
            placeholderNumberType: "off",
            preferredCountries: [],
            initialCountry: "auto",
            geoIpLookup: function (callback) {
                jQuery.get('https://ipinfo.io', function () { }, "jsonp").always(function (resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "";
                    callback(countryCode);
                });
            }
        });

        return itiPhone;
    }

    if (redi_restaurant_reservation.countrycode) {
        // intl-tel-input
        var itiUserPhone = get_tel_input(document.querySelector("#intlTel"));
        var waitlist_itiUserPhone = get_tel_input(document.querySelector("#waitlist-intlTel"));
        var itiUpdateUserPhone = get_tel_input(document.querySelector("#updateUserPhone-intlTel"));
        var itiModifyPhone = get_tel_input(document.querySelector("#modifyPhone-intlTel"));
        var itiCancelPhone = get_tel_input(document.querySelector("#cancelPhone-intlTel"));
        /* country code */


        if (jQuery('#UserPhone').val()) {
            itiUserPhone.setNumber(jQuery('#UserPhone').val());
        }

        if (jQuery('#waitlist-UserPhone').val()) {
            waitlist_itiUserPhone.setNumber(jQuery('#waitlist-UserPhone').val());
        }

        jQuery('#intlTel').keyup(function () {
            if (itiUserPhone.getValidationError()) {
                jQuery('#UserPhone').val('');
            } else {
                jQuery('#UserPhone').val(itiUserPhone.getNumber());
            }
            // set number 
            jQuery('#UserPhone').val(itiUserPhone.getNumber());

        });

        jQuery('#waitlist-intlTel').keyup(function () {
            if (waitlist_itiUserPhone.getValidationError()) {
                jQuery('#waitlist-UserPhone').val('');
            } else {
                jQuery('#waitlist-UserPhone').val(waitlist_itiUserPhone.getNumber());
            }
        });

        jQuery('#updateUserPhone-intlTel').keyup(function () {
            if (itiUpdateUserPhone.getValidationError()) {
                jQuery('#updateUserPhone').val('');
            } else {
                jQuery('#updateUserPhone').val(itiUpdateUserPhone.getNumber());
            }
        });

        jQuery('#cancelPhone-intlTel').keyup(function () {
            if (itiCancelPhone.getValidationError()) {
                jQuery('#redi-restaurant-cancelPhone').val('');
            } else {
                jQuery('#redi-restaurant-cancelPhone').val(itiCancelPhone.getNumber());
            }
        });

        jQuery('#modifyPhone-intlTel').keyup(function () {
            if (itiModifyPhone.getValidationError()) {
                jQuery('#redi-restaurant-modifyPhone').val('');
            } else {
                jQuery('#redi-restaurant-modifyPhone').val(itiModifyPhone.getNumber());
            }
        });
    }
    else {
        jQuery('#intlTel').keyup(function () {

            // set number 
            jQuery('#UserPhone').val(jQuery('#intlTel').val());

        });

        jQuery('#cancelPhone-intlTel').keyup(function () {

            jQuery('#redi-restaurant-cancelPhone').val(jQuery('#cancelPhone-intlTel').val());

        });

        jQuery('#modifyPhone-intlTel').keyup(function () {
            jQuery('#redi-restaurant-modifyPhone').val(jQuery('#modifyPhone-intlTel').val());
        });

        jQuery('#updateUserPhone-intlTel').keyup(function () {
            jQuery('#updateUserPhone').val(jQuery('#updateUserPhone-intlTel').val());
        });

        jQuery('#waitlist-intlTel').keyup(function () {
            jQuery('#waitlist-UserPhone').val(jQuery('#waitlist-intlTel').val());
        });

    }

    /*
    * Reservation user feedback form text area field require condiction manage here
    */
    jQuery(".userfeedback .radio label input[name='stars']").click(function () {
        if (jQuery('.userfeedback .radio input[name="stars"]:checked').val() > 3) {
            jQuery('.userfeedback span .req_start').html('');
            jQuery(".userfeedback textarea").removeAttr("required");
        } else {
            jQuery('.userfeedback textarea').attr('required', '');
            jQuery('.userfeedback span .req_start').html('*');
        }
    });
    /*
    * After Reservation form display feedback form fronted
    */
    jQuery("form.userfeedback").submit(function (e) {
        e.preventDefault();
        var data = {
            action: 'redi_userfeedback_submit',
            'review': jQuery('.radio input[name="stars"]:checked').val(),
            'message': jQuery('.userfeedback textarea').val(),
            'reservationid': jQuery.trim(jQuery('span#reservation-id').text()).replace(/ /g, ''),
        };
        jQuery.post(redi_restaurant_reservation.ajaxurl, data, function (response) {
            if (response['type'] == 'Error') {
                jQuery('.userfeedback #errors').html(response['message']).show('slow');
                jQuery('.userfeedback #sucess').hide();
            } else {
                jQuery('.userfeedback #sucess').html(response['message']).show('slow');
                jQuery('.userfeedback #errors').hide();
                jQuery('.userfeedback .field_row').hide();
            }
        }, 'json');
    });


    function showFirstAvailableMonthAndSelectDay() {

        var placeId = jQuery('#placeID').val();
        var guests = parseInt(jQuery('#persons').val()) + (jQuery('#children').val() === undefined ? 0 : parseInt(jQuery('#children').val()));
    
        if (guests == 0 || placeId == 0 || Number.isNaN(guests)) {
            return;
        }
    
        jQuery('#redi-date-block').show();
        jQuery('#redi-restaurant-startDate').hide();
        jQuery('#ui-datepicker-div').hide();
        jQuery('#step1errors').hide();
        jQuery('#date_info_load').show();
        jQuery('#date_info_load').focus();
    
        // Helper function to get query parameter from URL
        function getQueryParam(param) {
            let urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }
    
        // Get the select-date query parameter
        let selectDateParam = getQueryParam('select-date');
        let dateValue = selectDateParam ? moment(selectDateParam, 'YYYY-MM-DD') : moment();

        // Check if the date is in the past
        if (dateValue.isBefore(moment())) {
            dateValue = moment(); // Set to today's date if the selected date is in the future
        }
    
        // Navigate to the first day of the month
        var from = dateValue.clone().startOf('month');
        var to = moment(from).add(1, 'month').startOf('month');
    
        (async function () {
            let attempts = 0;
            let currentMonth = moment().startOf('month');
    
            // Calculate the difference in months between the current month and the selected month
            let monthDifference = from.diff(currentMonth, 'months');
    
            // Move the calendar to the correct month by clicking "next" or "prev"
            if (monthDifference > 0) {
                for (let i = 0; i < monthDifference; i++) {
                    jQuery('.ui-datepicker-next').click();
                }
            } else if (monthDifference < 0) {
                for (let i = 0; i < Math.abs(monthDifference); i++) {
                    jQuery('.ui-datepicker-prev').click();
                }
            }
    
            // After navigating to the correct month, check for available dates
            while (attempts < 6 && !await areThereAnyAvailableDaysInThisMonth(from, to, placeId)) {
                console.log('No dates available in this month ' + from.format('MMMM YYYY') + ', navigating to next month');
    
                attempts++;
                from = from.add(1, 'month').startOf('month');
                to = moment(from).add(1, 'month').startOf('month');
    
                // Trigger next month click
                jQuery('.ui-datepicker-next').click();
            }
    
            if (attempts >= 3) {
                console.log('Reached maximum number of attempts.');
            }
    
            calendarInitiated = true;
            jQuery('#date_info_load').hide();
            jQuery('#redi-restaurant-startDate').datepicker("refresh");
            jQuery('#redi-restaurant-startDate').show();
    
            // If a specific date is provided, select it
            if (selectDateParam) {
                // Set the date in the datepicker (this will select the date visually)
                jQuery('#redi-restaurant-startDate').datepicker('setDate', dateValue.toDate());
    
                // Refresh the datepicker to reflect the changes
                jQuery('#redi-restaurant-startDate').datepicker("refresh");
    
                // show available times for selected day
                getTimeByDate();
            }
        })();
    }
    
});

function saveDateInformation(placeId, guests, dates) {
    // Iterate through each date in dates
    dates.forEach(dateItem => {
        var newDateInfo = {
            month: dateItem.Date.substring(0, 7), // Extract YYYY-MM from Date
            placeId: placeId,
            guests: guests,
            data: new Array()
        };

        // Check for duplicates before adding
        var month = date_information.find(item =>
            item.month === newDateInfo.month &&
            item.placeId === newDateInfo.placeId &&
            item.guests === newDateInfo.guests
        );

        if (month == null)
        {
            date_information.push(newDateInfo);
            month = newDateInfo;
        }

        var date = month.data.find(o => o.Date === dateItem.Date)

        if (date == null) {
            month.data.push(dateItem);
        }
    });
}


async function areThereAnyAvailableDaysInThisMonth(from, to, placeId) {
    var placeId = jQuery('#placeID').val();
    var guests = parseInt(jQuery('#persons').val()) + (jQuery('#children').val() === undefined ? 0 : parseInt(jQuery('#children').val()));

    var data = {
        action: 'redi_restaurant-submit',
        get: 'date_information',
        from: from.format('YYYY-MM-DD'),
        to: to.format('YYYY-MM-DD'),
        placeID: placeId,
        apikeyid: apikeyid,
        guests: guests,
    };
    return new Promise((resolve, reject) => {
        jQuery.post(redi_restaurant_reservation.ajaxurl, data, function (response) {

            var fromMonthFormatted = moment(from).startOf('month');
            var fromMonth = fromMonthFormatted.format('YYYY-MM');
            var today = moment().startOf('day');
            var currentMonth = today.format('YYYY-MM');
            var endOfMonth = fromMonthFormatted.endOf('month');

            // Parse the response and filter dates from the specified month and from today till the end of the month
            var dates = JSON.parse(response).filter(item => {
                var itemDate = moment(item.Date);
                return itemDate.isSameOrAfter(today) && itemDate.isSameOrBefore(endOfMonth) && itemDate.format('YYYY-MM') === fromMonth;
            });

            saveDateInformation(placeId, guests, dates);

            var remainingDays = null;
            if (fromMonth === currentMonth) {
                // Calculate the remaining days including the current day
                remainingDays = endOfMonth.diff(today, 'days') + 1;
            }

            // Check if the number of dates matches the number of remaining days
            var condition = remainingDays !== null
                ? dates.length !== remainingDays
                : dates.length !== fromMonthFormatted.daysInMonth();
            resolve(condition);
        }).fail(function (err) {
            reject(err);
        });
    });
}




/********/

function zeroFill(i) {
    return (i < 10 ? '0' : '') + i
}

Date.createFromString = function (string) {
    'use strict';
    var pattern = /^(\d\d\d\d)-(\d\d)-(\d\d)[ T](\d\d):(\d\d)$/;
    var matches = pattern.exec(string);
    if (!matches) {
        throw new Error("Invalid string: " + string);
    }
    var year = matches[1];
    var month = matches[2] - 1;   // month counts from zero
    var day = matches[3];
    var hour = matches[4];
    var minute = matches[5];

    // Date.UTC() returns milliseconds since the unix epoch.
    var absoluteMs = Date.UTC(year, month, day, hour, minute, 0);

    return new Date(absoluteMs);
};

