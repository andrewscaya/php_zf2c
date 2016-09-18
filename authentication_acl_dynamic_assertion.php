<?php
include 'init_autoloader.php';

// returns TRUE if current time is between $start and $stop
use Zend\Permissions\Acl\Assertion\AssertionInterface;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\RoleInterface;
use Zend\Permissions\Acl\Resource\ResourceInterface;

class DateTimeAssertion implements AssertionInterface
{
    protected $startTime;
    protected $stopTime;
    public function __construct(\DateTime $start, \DateTime $stop)
    {
        $this->startTime = $start;
        $this->stopTime = $stop;
    }

    public function assert(Acl $acl,
                           RoleInterface $role = null,
                           ResourceInterface $resource = null,
                           $privilege = null)
    {
        $now   = new DateTime('now');
        return (($this->startTime <= $now) && ($now <= $this->stopTime));
    }
}

// Check against the dynamic assertion
$start = new DateTime();
$stop  = new DateTime();
$stop->add(new DateInterval('PT5M'));

// uncomment the following line and run again
//$stop->sub(new DateInterval('P1D'));

$dtAssertion = new DateTimeAssertion($start, $stop);
$acl = new Acl();
$acl->addRole('user');
$acl->addResource('z');
$acl->allow('user', 'z', 'access');
$acl->allow('user', 'z', 'access', $dtAssertion);

// To check if allowed:
echo ($acl->isAllowed('user','z','access')) ? 'ALLOWED' : 'DENIED';

// returns TRUE only if $dtAssertion returns TRUE
// $dtAssertion returns TRUE if current time is
// between $start and $stop
