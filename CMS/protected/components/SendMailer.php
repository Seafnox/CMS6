<?

/**
 * Class SendMailer класс для отправки почтовых сообщений
 */

class SendMailer extends CComponent
{

    /**
     * @var string от кого имя
     */
    public $fromText;

    /**
     * @var string от кого email
     */

    public $fromMail;


	public function init() {
		
		return true;
		
	}

    /**
     * Отправка письма
     * @param $subject тема
     * @param $message сообщение
     * @param $email кому
     * @param string $encoding кодировка, мо умолчанию utf-8
     * @return bool
     */

    public function mail($subject, $message, $email, $encoding = "utf-8")
    {

        $subject = '=?' . $encoding . '?B?' . base64_encode($subject) . '?=';

        $fromText = '=?' . $encoding . '?B?' . base64_encode($this->fromText) . '?=';

        $fromMail = $this->fromMail;

        $header = "MIME-Version: 1.0\n";
        $header .= "Content-type: text/html; charset=$encoding\n";
        $header .= "From: $fromText <$fromMail>\n";

        return mail($email, $subject, $message, $header);

    }


}

?>
