<?php

namespace app\jobs;

use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;
use app\models\Book;
use app\models\Subscription;

/**
 * Class NewBookNotificationJob
 */
class NewBookNotificationJob extends BaseObject implements JobInterface
{
    public $bookId;

    /**
     * @inheritdoc
     */
    public function execute($queue)
    {
        $book = Book::findOne($this->bookId);
        if (!$book) {
            return;
        }

        echo "Processing book: {$book->title}\n";

        // Find authors of this book
        $authors = $book->authors;
        foreach ($authors as $author) {
            // Find subscriptions for this author
            $subscriptions = Subscription::find()
                ->where(['author_id' => $author->id])
                ->all();

            foreach ($subscriptions as $subscription) {
                $user = $subscription->user;
                if ($user && $user->phone) {
                    $message = "New book by {$author->full_name}: {$book->title}";
                    Yii::$app->smsSender->send($user->phone, $message);
                }
            }
        }
    }
}
