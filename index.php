<?php
/*

Черный ящик - Инкапсуляция

a. Создайте классы
■ BlackBox - черный ящик, у него должно быть закрытое от всех свойство private $data
■ Plane - Самолет, должен содержать закрытое свойство private $blackBox, в конструкторе это
свойство должно быть проинициализировано новым классом BlackBox
■ Engineer - Инженер - дешифровщик черных ящиков.

b. Класс BlackBox содержит следующие методы:
■ public function addLog($message) - добавляет очередную строку в свое свойство $data
■ public function getDataForEngineer(Engineer $engineer) - возвращает свои данные для
инженера.

c. Класс Plane должен содержать методы:
■ public function flyAndCrush()
{
$this->crushProcess();
}
■ flyProcess - процесс полета может проходить по-другому для других самолетов, пишет лог в
черный ящик, придумайте что будет записано в этом методе в черный ящик.
■ crushProcess - процесс крушения переопределен быть не может, пишет лог в черный ящик,
придумайте что будет записано в этом методе в черный ящик.
■ protected function addLog($message) - передает сообщение для записи в лог черного ящика.
■ public function getBoxForEngineer(Engineer $engineer)
{
$engineer->setBox($this->blackBox);
}

d. Реализуйте класс Engineer
■ public function setBox(BlackBox $blackBox) - устанавливает черный ящик для дешифрации у
инженера

■ public function takeBox(Plane $plane) - должен доставать черный ящик из самолета
(посмотрите какой подходящий метод есть в классе Plane)

■ public function decodeBox() - декодирует черный ящик - выводит на экран лог черного
ящика

e. Реализуйте методы без изменения области видимости методов и свойств.

f. Создайте самолет, устройте ему полет с крушением.

g. Создайте инженера, возьмите черный ящик из упавшего самолета и дешифруйте его.

h. Создайте новый вид самолета (наследуйтесть от Plane). Самолет должен вести другой лог во
время полета. Но, к сожалению, путь его тот же что и для предыдущего самолета. Дешифруйте и
его лог.

*/

namespace BlackBox;

class BlackBox
{
	private $data; //private

	public function addLog($message)
	{
		$this->data .= $message;
	}

	public function getDataForEngineer(Engineer $engineer)
	{
		return $this->data;
	}
}

class Plane
{
	private $blackBox; //private

	public function __construct()
    {
        $this->blackBox = new BlackBox;
    }

	public function flyAndCrush()
	{
		$this->flyProcess();
		$this->crushProcess();
	}

	public function flyProcess() 
	{	
		$this->addLog(' Летим все круто!' . '</br>');
	}

	// ■ crushProcess - процесс крушения переопределен быть не может, пишет лог в черный ящик,
// придумайте что будет записано в этом методе в черный ящик.

	public function crushProcess()
	{
		$this->addLog(' Мы падаем, прощайте' . '</br>');
	}

// ■ protected function addLog($message) - передает сообщение для записи в лог черного ящика.

	protected function addLog($message) //protected
	{
		$this->blackBox->addLog($message);
	}

	public function getBoxForEngineer(Engineer $engineer)
	{
		$engineer->setBox($this->blackBox);
	}
}

class Engineer 
{
	private $blackBox; //private

// ■ public function setBox(BlackBox $blackBox) - устанавливает черный ящик для дешифрации у
// инженера

	public function setBox(BlackBox $blackBox)
	{
		$this->blackBox = $blackBox;
	}

// ■ public function takeBox(Plane $plane) - должен доставать черный ящик из самолета
// (посмотрите какой подходящий метод есть в классе Plane)

	public function takeBox(Plane $plane)
	{
		$plane->getBoxForEngineer($this);
	}

// ■ public function decodeBox() - декодирует черный ящик - выводит на экран лог черного ящика

	public function decodeBox()
	{
		echo $this->blackBox->getDataForEngineer($this);
	}
}

class PlaneSecond extends Plane
{
	public function flyProcess() 
	{	
		$this->addLog(' Вылетили на поиски упавшего самолета' . '</br>');
	}

	public function crushProcess()
	{
		$this->addLog(' Черт мы теряем высоту!' . '</br>');
	}
}

echo '<h1>Первый самолет!</h1>';

//f. Создайте самолет, устройте ему полет с крушением.
$plane = new Plane();
$plane->flyAndCrush();

//g. Создайте инженера, возьмите черный ящик из упавшего самолета и дешифруйте его.
$engineer = new Engineer();
$engineer->takeBox($plane);
$engineer->decodeBox();

echo '<h1>Второй самолет!</h1>';

$plane2 = new PlaneSecond();
$plane2->flyAndCrush();

$engineer->takeBox($plane2);
$engineer->decodeBox();

