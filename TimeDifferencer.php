<?php
/**
 * Created by PhpStorm.
 * User: Martin Forejt, forejt.martin97@gmail.com
 * Date: 09.07.2016
 * Time: 18:16
 */

/**
 * Class TimeDifferencer
 * @package AppBundle\Model
 */
class TimeDifferencer
{
    /**
     * @var \DateTime $start
     */
    private static $start;

    /**
     * @var \DateTime $end ;
     */
    private static $end;

    /**
     * @var array $defaultParams
     */
    private static $params = array(
        'lang' => 'cs',
        'max_days' => 5,
        'minutes_step' => 1,
        'now' => null
    );

    /**
     * Calculate difference of 2 times to text
     *
     * @param \DateTime $start
     * @param \DateTime|null $end
     * @param array $parameters
     * @return string
     */
    public static function getDifference(\DateTime $start, \DateTime $end = null, $parameters = array())
    {
        self::$params = $parameters + self::$params;

        if ($end == null) $end = new \DateTime('now');
        TimeDifferencer::$start = $start;
        TimeDifferencer::$end = $end;

        $diff = date_diff($start, $end);
        $days = $diff->format('%a');
        $hours = $diff->format('%h');
        $minutes = $diff->format('%i');

        if ($days > 0) $result = self::daysDiff($days);
        elseif ($hours > 0) $result = self::hoursDiff($hours);
        elseif ($minutes > 0) $result = self::minutesDiff($minutes);
        else $result = self::$params['now'] == null ? self::$now[self::$params['lang']] : self::$params['now'];

        return $result;
    }

    /**
     * @param int $days
     * @return string
     */
    private static function daysDiff($days)
    {
        if ($days <= self::$params['max_days']) return $days . ' ' . self::$days[self::getPlural($days)][self::$params['lang']];
        else {
            return self::$start->format('j. ') . self::$months[intval(self::$start->format('m'))][self::$params['lang']] . ' ' . self::$start->format('Y');
        }
    }

    /**
     * @param int $hours
     * @return string
     */
    private static function hoursDiff($hours)
    {
        return $hours . ' ' . self::$hours[self::getPlural($hours)][self::$params['lang']];
    }

    /**
     * @param int $minutes
     * @return string
     */
    private static function minutesDiff($minutes)
    {
        $step = self::$params['minutes_step'];
        if ($minutes % $step != 0) {
            $up = $down = $minutes;
            while ($up % $step != 0 && $down % $step != 0 && $down > 0) {
                $up++;
                $down--;
            }
            if ($up % $step == 0) $minutes = $up;
            else $minutes = $down;
        }

        return $minutes . ' ' . self::$minutes[self::getPlural($minutes)][self::$params['lang']];
    }

    /**
     * @param int $count
     * @return int
     */
    private static function getPlural($count)
    {
        if ($count == 1) return 1;
        elseif ($count > 1 && $count <= 4) return 2;
        else return 3;
    }

    /**
     * @var array $months
     */
    private static $months = array(
        1 => array('cs' => 'Leden', 'en' => 'January'),
        2 => array('cs' => 'Únor', 'en' => 'February'),
        3 => array('cs' => 'Březen', 'en' => 'March'),
        4 => array('cs' => 'Duben', 'en' => 'April'),
        5 => array('cs' => 'Květen', 'en' => 'May'),
        6 => array('cs' => 'Červen', 'en' => 'June'),
        7 => array('cs' => 'Červenec', 'en' => 'July'),
        8 => array('cs' => 'Srpen', 'en' => 'August'),
        9 => array('cs' => 'Září', 'en' => 'September'),
        10 => array('cs' => 'Říjen', 'en' => 'October'),
        11 => array('cs' => 'Listopad', 'en' => 'November'),
        12 => array('cs' => 'Prosinec', 'en' => 'December')
    );

    /**
     * @var array $days
     */
    private static $days = array(
        1 => array('cs' => 'den', 'en' => 'day'),
        2 => array('cs' => 'dny', 'en' => 'days'),
        3 => array('cs' => 'dní', 'en' => 'days')
    );

    /**
     * @var array $hours
     */
    private static $hours = array(
        1 => array('cs' => 'hodina', 'en' => 'hour'),
        2 => array('cs' => 'hodiny', 'en' => 'hours'),
        3 => array('cs' => 'hodin', 'en' => 'hours')
    );

    /**
     * @var array §minutes
     */
    private static $minutes = array(
        1 => array('cs' => 'minuta', 'en' => 'minute'),
        2 => array('cs' => 'minuty', 'en' => 'minutes'),
        3 => array('cs' => 'minut', 'en' => 'minutes')
    );

    private static $now = array(
        'cs' => 'Právě teď',
        'en' => 'Just now'
    );

}