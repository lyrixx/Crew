<?php



/**
 * Skeleton subclass for representing a row from the 'branch' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.5.6 on:
 *
 * Mon Oct 24 09:36:19 2011
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.lib.model
 */
class Branch extends BaseBranch
{
  /**
   * @return string
   */
  public function __toString()
  {
    return $this->getName();
  }

  public function changeStatus($newStatus, $user, $con = null)
  {
    $this
      ->setStatus($newStatus)
      ->setCommitStatusChanged($this->getLastCommit())
      ->setUserStatusChanged($user)
      ->setDateStatusChanged(time())
      ->setReviewRequest(false)
      ->save($con)
    ;
  }

  /**
   * @static
   * @param int $userId
   * @param int $repositoryId
   * @param int $branchId
   * @param int $oldStatus
   * @param int $newStatus
   * @param string $message
   * @return int
   */
  public static function saveAction($userId, $repositoryId, $branchId, $oldStatus, $newStatus, $message = 'status was changed from <strong>%s</strong> to <strong>%s</strong>')
  {
    if ($oldStatus === $newStatus)
    {
      return 0;
    }

    $branch = BranchQuery::create()->filterById($branchId)->findOne();
    if(!$branch)
    {
      return false;
    }

    $statusAction = new StatusAction();
    return $statusAction
      ->setUserId($userId)
      ->setRepositoryId($repositoryId)
      ->setBranchId($branchId)
      ->setOldStatus($oldStatus)
      ->setNewStatus($newStatus)
      ->setMessage(sprintf($message, BranchPeer::getLabelStatus($oldStatus), BranchPeer::getLabelStatus($newStatus)))
      ->save()
    ;
  }
} // Branch
