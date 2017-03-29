<?php
/**
 * Code written is strictly used within this program.
 * Any other use of this code is in violation of copy rights.
 *
 * @package   Core
 * @author    Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright 2016 Developer
 * @license   - No License
 * @version   GIT: $Id$
 * @link      -
 */
namespace Bridge\Core\Contracts;

/**
 * SubjectInterface class description.
 *
 * @package    Core
 * @subpackage Contracts
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
interface SubjectInterface
{

    /**
     * Attach an observer.
     *
     * @param \Bridge\Core\Contracts\ObserverInterface $observer The observer parameter.
     *
     * @return void
     */
    public function attachObserver(\Bridge\Core\Contracts\ObserverInterface $observer);

    /**
     * Detach an observer.
     *
     * @param \Bridge\Core\Contracts\ObserverInterface $observer The observer parameter.
     *
     * @return void
     */
    public function detachObserver(\Bridge\Core\Contracts\ObserverInterface $observer);

    /**
     * Notify all the observers that has been registered.
     *
     * @return void
     */
    public function doNotifyToAllObserver();
}
