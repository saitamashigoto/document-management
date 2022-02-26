<?php
declare(strict_types=1);

namespace App\Controller;

class ChartsController extends AppController
{
    use \Cake\ORM\Locator\LocatorAwareTrait;
    
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->Authentication->addUnauthenticatedActions(['index']);
    }

    public function index()
    {
        $this->Authorization->skipAuthorization();
        $monthlyStats = $this->getMonthlyStats();
        $this->set(compact('monthlyStats'));
        $this->viewBuilder()->setOption('serialize', ['monthlyStats']);
    }

    protected function getMonthlyStats()
    {
        $monthlyStats = [['日', 'ユーザ', '書籍', '作者']];
        $lastDayOfCurrentMonth = (int)date('t');
        for ($day = 1; $day <= $lastDayOfCurrentMonth; $day++) {
            $prefixedDay = $this->prefixZero($day);
            $authors = $this->getTableLocator()
                ->get('Authors')->find();
            $authors = $authors->select(['count' => $authors->func()->count('*')])
                ->where('created BETWEEN :start AND :end')
                ->bind(':start', date("Y-m-$prefixedDay 00:00:00"), 'datetime')
                ->bind(':end', date("Y-m-$prefixedDay 23:59:59"), 'datetime')
                ->firstOrFail()
                ->toArray()['count'];

            $documents = $this->getTableLocator()
                ->get('Books')->find();
            $documents = $documents->select(['count' => $documents->func()->count('*')])
                ->where('created BETWEEN :start AND :end')
                ->bind(':start', date("Y-m-$prefixedDay 00:00:00"), 'datetime')
                ->bind(':end', date("Y-m-$prefixedDay 23:59:59"), 'datetime')
                ->firstOrFail()
                ->toArray()['count'];

            $users = $this->getTableLocator()
                ->get('Users')->find();
            $users = $users->select(['count' => $users->func()->count('*')])
                ->where('created BETWEEN :start AND :end')
                ->bind(':start', date("Y-m-$prefixedDay 00:00:00"), 'datetime')
                ->bind(':end', date("Y-m-$prefixedDay 23:59:59"), 'datetime')
                ->firstOrFail()
                ->toArray()['count'];
            $monthlyStats[] = [$day, $users, $documents, $authors];
        }
        return $monthlyStats;
    }

    protected function prefixZero($number)
    {
        if ($number < 10) {
            return '0'.$number;
        }
        return $number;
    }
}
