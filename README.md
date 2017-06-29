# TimeDifferencer
Calculate difference between 2 dates, result in text.
## Usage
```
TimeDifference::getDifference($date1, $date2, array('lang' => 'en', 'minutes_step' => 5));

Output e.g. Just now / 10 minutes / 2 hours / 3 days / 14. July 2016 
```
## Parameters
```
TimeDefferencer::getDifference($start, $end = null, $parameters = array())
```
#### start: DateTime
#### end(optional): DateTime / null - default is current date
#### parameters(optional): array
- lang - cs/en, default = cs
- max_days - max days and then full date, default = 5
- minutes_step - e.g. 5 - 5,10,15,.., default = 1
- now - now text, default = "Právě teď" / "Just now"
