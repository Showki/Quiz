<?php
class QuizJapansController extends AppController {
	public $name = 'QuizJapan';
	public $uses = array('Quiz');
	public $components = array('DebugKit.Toolbar');

	public function index(){
		$this->redirect(array('controller'=>'QuizJapans','action'=>'input_data'));
		// $this->set('data',$this->request->data);
	}
	public function input_data(){
		//何かを送信した後
		if(!empty($this->request->data)){
			if(!empty($this->request->data['area_submit'])){
				$data = $this->request->data;
				$area_num = $data['area'];
				$data['area_data'] = $this->Quiz->all_area_data($area_num);
				$this->set('data',$data);
			}
		//送信前	
		}else{
			$data = $this->Quiz->area_data();
			$this->set('data',$data['area']);			
		}
	}
	public function get_select_data(){
		if(!empty($this->request->data)){
			if($this->request->data['all_area_submit']){
				$data = $this->request->data;
				$reg_num = $this->Quiz->regional_data($data);
				$data['reg_name'] = $this->Quiz->regional_data($data);
				$json_data = $this->Quiz->data_getter($reg_num);
				$select_data = $this->Quiz->data_selection($json_data);
				//一問一答形式の生成
				$sentence_data = $this->Quiz->make_sentence($select_data);

				$this->set('data',$sentence_data);
				//以降、誤答選択肢の生成
				$reg_data = $this->Quiz->make_wrong($data['area']);
			 	$json_data2 = $this->Quiz->data_getter($reg_data[1]['reg_name']);
			 	$select_data2 = $this->Quiz->data_selection($json_data2);
			    $wrong_data[1] = $this->Quiz->make_wrong_sec($select_data2);

				$reg_data = $this->Quiz->make_wrong($data['area']);
			 	$json_data2 = $this->Quiz->data_getter($reg_data[2]['reg_name']);
			 	$select_data2 = $this->Quiz->data_selection($json_data2);
			    $wrong_data[2] = $this->Quiz->make_wrong_sec($select_data2);

				$reg_data = $this->Quiz->make_wrong($data['area']);
			 	$json_data2 = $this->Quiz->data_getter($reg_data[3]['reg_name']);
			 	$select_data2 = $this->Quiz->data_selection($json_data2);
			    $wrong_data[3] = $this->Quiz->make_wrong_sec($select_data2);

			    $quiz_data['sentence_data'] = $sentence_data;
			    $quiz_data['wrong_data'] = $wrong_data;
			    $data['quiz_sentence'] = $this->Quiz->make_quiz($quiz_data);			   

				// foreach ($data['quiz_sentence'] as $key => $value) {
				// 	shuffle($data['quiz_sentence'][$key]);
				// }
				$this->set('data',$data);
			}
		}else{
			$this->redirect(array('controller'=>'QuizJapans','action'=>'input_data'));
		}
	}
	public function checking_answers(){
		if(!empty($this->request->data['answer_submit'])){
			$this->set('data',$this->request->data);
		}else{
			$this->redirect(array('controller'=>'QuizJapans','action'=>'input_data'));
		}
	}

}
?>