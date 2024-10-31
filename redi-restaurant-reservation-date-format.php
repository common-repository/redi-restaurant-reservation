<?php
if ( ! class_exists( 'RediDateFormats' ) ) {
	class RediDateFormats {
static function getCalendarDateFormat($format)
{
    switch ($format) {
        case 'MM-dd-yyyy':
            return 'mm-dd-yy';

        case 'dd-MM-yyyy':
            return 'dd-mm-yy';

        case 'yyyy.MM.dd':
            return 'yy.mm.dd';

        case 'MM.dd.yyyy':
            return 'mm.dd.yy';

        case 'dd.MM.yyyy':
            return 'dd.mm.yy';

        case 'yyyy/MM/dd':
            return 'yy/mm/dd';

        case 'MM/dd/yyyy':
            return 'mm/dd/yy';

        case 'dd/MM/yyyy':
            return 'dd/mm/yy';
    }

    return 'yy-mm-dd';
}

static function getPHPDateFormat($format)
{
    switch ($format) {
        case 'MM-dd-yyyy':
            return 'm-d-Y';

        case 'dd-MM-yyyy':
            return 'd-m-Y';

        case 'yyyy.MM.dd':
            return 'Y.m.d';

        case 'MM.dd.yyyy':
            return 'm.d.Y';

        case 'dd.MM.yyyy':
            return 'd.m.Y';

        case 'yyyy/MM/dd':
            return 'Y/m/d';

        case 'MM/dd/yyyy':
            return 'm/d/Y';

        case 'dd/MM/yyyy':
            return 'd/m/Y';
    }

    return 'Y-m-d';
}

}
}