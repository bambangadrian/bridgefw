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
 * ObserverInterface class description.
 *
 * @package    Core
 * @subpackage Contracts
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
interface ObserverInterface
{

    /**
     * Receive update from subject.
     *
     * @param \Bridge\Core\Contracts\SubjectInterface $subject The Subject that notifying the observer of an update.
     *
     * @return void
     */
    public function update(\Bridge\Core\Contracts\SubjectInterface $subject);
}
