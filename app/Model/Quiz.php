<?php 
class Quiz extends AppModel{
	var $name = "Quiz";
	var $useTable = false;
	//データベースを用いてやりなおす
	public function all_area_data($area_num){
		$regional = array(
			0 => array(
				"北海道",
				"青森県",
				"岩手県",
				"宮城県",
				"秋田県",				
				"山形県",
				"福島県"),
			1 => array(
				"茨城県",
				"栃木県",
				"群馬県",
				"埼玉県",
				"千葉県",
				"東京都",
				"神奈川県"),
			2 => array(
				"新潟県",
				"富山県",
				"石川県",
				"福井県",
				"山梨県",
				"長野県",
				"岐阜県",
				"静岡県",				
				"愛知県" ),
			3 => array(
				"三重県",
				"滋賀県",
				"京都府",
				"大阪府",
				"兵庫県",
				"奈良県",
				"和歌山県"),
			4 => array(
				"鳥取県",
				"島根県",
				"岡山県",
				"広島県",				
				"山口県"),
			5 => array(				  
				"徳島県",
				"香川県",
				"愛媛県",
				"高知県"),
			6 => array(
				"福岡県",
				"佐賀県",
				"長崎県",
				"熊本県",
				"大分県",
				"宮崎県",
				"鹿児島県",
				"沖縄県")
			);
		$area = array(
			0 => "北海道+東北地方",
			1 => "関東地方",
			2 => "中部地方",
			3 => "近畿地方",
			4 => "中国地方",
			5 => "四国地方",
			6 => "九州地方"
			);
		$data['area'] = $area[$area_num];
		$data['regional'] = $regional[$area_num];
		return $data;
	}
	public function area_data(){
		$data["area"] = array(
			0 => "北海道+東北地方",
			1 => "関東地方",
			2 => "中部地方",
			3 => "近畿地方",
			4 => "中国地方",
			5 => "四国地方",
			6 => "九州地方"
			);
		return $data;
	}
	public function regional_data($data){
		$regional_area = array(
			0 => array(
				"北海道",
				"青森県",
				"岩手県",
				"宮城県",
				"秋田県",				
				"山形県",
				"福島県"),
			1 => array(
				"茨城県",
				"栃木県",
				"群馬県",
				"埼玉県",
				"千葉県",
				"東京都",
				"神奈川県"),
			2 => array(
				"新潟県",
				"富山県",
				"石川県",
				"福井県",
				"山梨県",
				"長野県",
				"岐阜県",
				"静岡県",				
				"愛知県" ),
			3 => array(
				"三重県",
				"滋賀県",
				"京都府",
				"大阪府",
				"兵庫県",
				"奈良県",
				"和歌山県"),
			4 => array(
				"鳥取県",
				"島根県",
				"岡山県",
				"広島県",				
				"山口県"),
			5 => array(				  
				"徳島県",
				"香川県",
				"愛媛県",
				"高知県"),
			6 => array(
				"福岡県",
				"佐賀県",
				"長崎県",
				"熊本県",
				"大分県",
				"宮崎県",
				"鹿児島県",
				"沖縄県")
			);
			$area_num = $data['area'];
			$regional_num = $data['regional'];
			return $regional_area[$area_num][$regional_num];
	}
	public function data_getter($keyword){
		$keyword = mb_convert_encoding($keyword, 'UTF-8', 'auto');
		$keyword = urlencode($keyword);
		$json = file_get_contents("http://www.wikipediaontology.org/data/instance/".$keyword.".json");
		$json_data =json_decode($json,true);
		return $json_data;
	}
	public function data_selection($json_data){
		foreach ($json_data[3] as $key => $value){
			if(!empty($value[0]) && !empty($value[1]['rdf:resource'])){
				if($value[0] == 'jwo-prop:隣接都道府県'){
					$data['隣接都道府県'][] = 	str_replace('http://www.wikipediaontology.org/instance/',"",$value[1]['rdf:resource']);
				}elseif($value[0] == 'jwo-prop:自治体'){
					$data['自治体'][] = 	str_replace('http://www.wikipediaontology.org/instance/',"",$value[1]['rdf:resource']);
				}elseif($value[0] == 'jwo-prop:道路'){
					$data['道路'][] = str_replace('http://www.wikipediaontology.org/instance/',"",$value[1]['rdf:resource']);
				}elseif($value[0] == 'jwo-prop:観光'){
					$data['観光'][] = str_replace('http://www.wikipediaontology.org/instance/',"",$value[1]['rdf:resource']);
				}elseif($value[0] == 'jwo-prop:有形文化財建造物'){
					$data['有形文化財建造物'][] = str_replace('http://www.wikipediaontology.org/instance/',"",$value[1]['rdf:resource']);
				}elseif($value[0] == 'jwo-prop:地形'){
					$data['地形'][] = str_replace('http://www.wikipediaontology.org/instance/',"",$value[1]['rdf:resource']);
				}elseif($value[0] == 'jwo-prop:県の花'){
					$data['県の花'][] = str_replace('http://www.wikipediaontology.org/instance/',"",$value[1]['rdf:resource']);
				}elseif($value[0] == 'jwo-prop:県の木'){
					$data['県の木'][] = str_replace('http://www.wikipediaontology.org/instance/',"",$value[1]['rdf:resource']);
				}elseif($value[0] == 'jwo-prop:県の鳥'){
					$data['県の鳥'][] = str_replace('http://www.wikipediaontology.org/instance/',"",$value[1]['rdf:resource']);
				}
			}
		}
		return $data;
	}
	public function make_sentence($select_data){
		foreach ($select_data as $key => $value) {
			$num = count($value) -1;
			if($key == '隣接都道府県'){
				$data['隣接都道府県']['sentence'] = "の隣接都道府県として正しいものはなにか？";
				$data['隣接都道府県']['right'] = $value[rand(0,$num)];
			}elseif($key == '自治体'){
				$data['自治体']['sentence'] = "に含まれる自治体として正しいものはなにか？";
				$data['自治体']['right'] = $value[rand(0,$num)];
			}elseif($key == '道路'){
				$data['道路']['sentence'] = "に含まれる道路として正しいものはなにか？";
				$data['道路']['right'] = $value[rand(0,$num)];
			}elseif($key == '観光'){
				$data['観光']['sentence'] = "で有名な観光地はなにか？";
				$data['観光']['right'] = $value[rand(0,$num)];
			}elseif($key == '有形文化財建造物'){
				$data['有形文化財建造物']['sentence'] = "にある有形文化財建造物として正しいものはなにか？";
				$data['有形文化財建造物']['right'] = $value[rand(0,$num)];
			}elseif($key == '地形'){
				$data['地形']['sentence'] = "にあるものとして正しいものはなにか？";
				$data['地形']['right'] = $value[rand(0,$num)];
			}elseif($key == '県の花'){
				$data['県の花']['sentence'] = "の県の花はなにか？";
				$data['県の花']['right'] = $value[rand(0,$num)];
			}elseif($key == '県の木'){
				$data['県の木']['sentence'] = "の県の木はなにか？";
				$data['県の木']['right'] = $value[rand(0,$num)];
			}elseif($key == '県の鳥'){
				$data['県の鳥']['sentence'] = "の県の鳥はなにか？";
				$data['県の鳥']['right'] = $value[rand(0,$num)];
			}
		}
		if(!empty($data)){
			return $data;
		}else{
			return false;
		}
	}
	public function make_wrong($input_num){
		$regional = array(
			0 => array(
				"北海道",
				"青森県",
				"岩手県",
				"宮城県",
				"秋田県",				
				"山形県",
				"福島県"),
			1 => array(
				"茨城県",
				"栃木県",
				"群馬県",
				"埼玉県",
				"千葉県",
				"東京都",
				"神奈川県"),
			2 => array(
				"新潟県",
				"富山県",
				"石川県",
				"福井県",
				"山梨県",
				"長野県",
				"岐阜県",
				"静岡県",				
				"愛知県" ),
			3 => array(
				"三重県",
				"滋賀県",
				"京都府",
				"大阪府",
				"兵庫県",
				"奈良県",
				"和歌山県"),
			4 => array(
				"鳥取県",
				"島根県",
				"岡山県",
				"広島県",				
				"山口県"),
			5 => array(				  
				"徳島県",
				"香川県",
				"愛媛県",
				"高知県"),
			6 => array(
				"福岡県",
				"佐賀県",
				"長崎県",
				"熊本県",
				"大分県",
				"宮崎県",
				"鹿児島県",
				"沖縄県")
			);
		$area = array(
			0 => "北海道+東北地方",
			1 => "関東地方",
			2 => "中部地方",
			3 => "近畿地方",
			4 => "中国地方",
			5 => "四国地方",
			6 => "九州地方"
			);

		$area_num = count($area)-1;
		$num[1]['area_num'] = 0;
		$num[2]['area_num'] = 0;
		$num[3]['area_num'] = 0;
		// 全て異なる値になるまで繰り返し処理をする
			// ($input_num == $num[1]['area_num']) &&
			// ($input_num == $num[2]['area_num']) &&
			// ($input_num == $num[3]['area_num'])
		//改善の余地あり
		while ($num[1]['area_num'] === $num[2]['area_num'] &&
			   $num[2]['area_num'] === $num[3]['area_num'] &&
			   $num[1]['area_num'] === $num[3]['area_num']
	   		  )
		{
			$num[1]['area_num'] = rand(0,$area_num);
			$num[2]['area_num'] = rand(0,$area_num);
			$num[3]['area_num'] = rand(0,$area_num);			
		}
	
		$num[1]['reg_num'] = rand(0,count($regional[$num[1]['area_num']])-1);
		$num[2]['reg_num'] = rand(0,count($regional[$num[2]['area_num']])-1);
		$num[3]['reg_num'] = rand(0,count($regional[$num[3]['area_num']])-1);		
		$num[1]['reg_name'] = $regional[$num[1]['area_num']][$num[1]['reg_num']];
		$num[2]['reg_name'] = $regional[$num[2]['area_num']][$num[2]['reg_num']];
		$num[3]['reg_name'] = $regional[$num[3]['area_num']][$num[3]['reg_num']];

		// $keyword = mb_convert_encoding($num[1]['reg_name'], 'UTF-8', 'auto');
		// $keyword = urlencode($keyword);
		// $json = file_get_contents("http://www.wikipediaontology.org/data/instance/".$keyword.".json");
		// $json_data =json_decode($json,true);
		// // $num[1]['json_data'] = $json_data;
		return $num;
	}
	public function make_wrong_sec($select_data){
		foreach ($select_data as $key => $value) {
			$num = count($value) -1;
			if($key == '隣接都道府県'){
				$data['隣接都道府県']['wrong'] = $value[rand(0,$num)];
			}elseif($key == '自治体'){
				$data['自治体']['wrong'] = $value[rand(0,$num)];
			}elseif($key == '道路'){
				$data['道路']['wrong'] = $value[rand(0,$num)];
			}elseif($key == '観光'){
				$data['観光']['wrong'] = $value[rand(0,$num)];
			}elseif($key == '有形文化財建造物'){
				$data['有形文化財建造物']['wrong'] = $value[rand(0,$num)];
			}elseif($key == '地形'){
				$data['地形']['wrong'] = $value[rand(0,$num)];
			}elseif($key == '県の花'){
				$data['県の花']['wrong'] = $value[rand(0,$num)];
			}elseif($key == '県の木'){
				$data['県の木']['wrong'] = $value[rand(0,$num)];
			}elseif($key == '県の鳥'){
				$data['県の鳥']['wrong'] = $value[rand(0,$num)];
			}
		}
		return $data;
	}
	public function make_quiz($quiz_data){
		foreach ($quiz_data['sentence_data'] as $key => $value) {
			$num = count($value) -1;
			if($key == '隣接都道府県'){
				if(!empty($quiz_data['wrong_data'][1]['隣接都道府県'])){
					$quiz_data['sentence_data']['隣接都道府県']['wrong_1'] = 
					$quiz_data['wrong_data'][1]['隣接都道府県']['wrong'];
				}
				if(!empty($quiz_data['wrong_data'][2]['隣接都道府県'])){
					$quiz_data['sentence_data']['隣接都道府県']['wrong_2'] = 
					$quiz_data['wrong_data'][2]['隣接都道府県']['wrong'];
				}
				if(!empty($quiz_data['wrong_data'][3]['隣接都道府県'])){
					$quiz_data['sentence_data']['隣接都道府県']['wrong_3'] = 
					$quiz_data['wrong_data'][3]['隣接都道府県']['wrong'];
				}
			}elseif($key == '自治体'){
				if(!empty($quiz_data['wrong_data'][1]['自治体'])){
					$quiz_data['sentence_data']['自治体']['wrong_1'] = 
					$quiz_data['wrong_data'][1]['自治体']['wrong'];
				}
				if(!empty($quiz_data['wrong_data'][2]['自治体'])){
					$quiz_data['sentence_data']['自治体']['wrong_2'] = 
					$quiz_data['wrong_data'][2]['自治体']['wrong'];
				}
				if(!empty($quiz_data['wrong_data'][3]['自治体'])){
					$quiz_data['sentence_data']['自治体']['wrong_3'] = 
					$quiz_data['wrong_data'][3]['自治体']['wrong'];
				}
			}elseif($key == '道路'){
				if(!empty($quiz_data['wrong_data'][1]['道路'])){
					$quiz_data['sentence_data']['道路']['wrong_1'] = 
					$quiz_data['wrong_data'][1]['道路']['wrong'];
				}
				if(!empty($quiz_data['wrong_data'][2]['道路'])){
					$quiz_data['sentence_data']['道路']['wrong_2'] = 
					$quiz_data['wrong_data'][2]['道路']['wrong'];
				}
				if(!empty($quiz_data['wrong_data'][3]['道路'])){
					$quiz_data['sentence_data']['道路']['wrong_3'] = 
					$quiz_data['wrong_data'][3]['道路']['wrong'];
				}
			}elseif($key == '観光'){
				if(!empty($quiz_data['wrong_data'][1]['観光'])){
					$quiz_data['sentence_data']['観光']['wrong_1'] = 
					$quiz_data['wrong_data'][1]['観光']['wrong'];
				}
				if(!empty($quiz_data['wrong_data'][2]['観光'])){
					$quiz_data['sentence_data']['観光']['wrong_2'] = 
					$quiz_data['wrong_data'][2]['観光']['wrong'];
				}
				if(!empty($quiz_data['wrong_data'][3]['観光'])){
					$quiz_data['sentence_data']['観光']['wrong_3'] = 
					$quiz_data['wrong_data'][3]['観光']['wrong'];
				}
			}elseif($key == '有形文化財建造物'){
				if(!empty($quiz_data['wrong_data'][1]['有形文化財建造物'])){
					$quiz_data['sentence_data']['有形文化財建造物']['wrong_1'] = 
					$quiz_data['wrong_data'][1]['有形文化財建造物']['wrong'];
				}
				if(!empty($quiz_data['wrong_data'][2]['有形文化財建造物'])){
					$quiz_data['sentence_data']['有形文化財建造物']['wrong_2'] = 
					$quiz_data['wrong_data'][2]['有形文化財建造物']['wrong'];
				}
				if(!empty($quiz_data['wrong_data'][3]['有形文化財建造物'])){
					$quiz_data['sentence_data']['有形文化財建造物']['wrong_3'] = 
					$quiz_data['wrong_data'][3]['有形文化財建造物']['wrong'];
				}
			}elseif($key == '地形'){
				if(!empty($quiz_data['wrong_data'][1]['地形'])){
					$quiz_data['sentence_data']['地形']['wrong_1'] = 
					$quiz_data['wrong_data'][1]['地形']['wrong'];
				}
				if(!empty($quiz_data['wrong_data'][2]['地形'])){
					$quiz_data['sentence_data']['地形']['wrong_2'] = 
					$quiz_data['wrong_data'][2]['地形']['wrong'];
				}
				if(!empty($quiz_data['wrong_data'][3]['地形'])){
					$quiz_data['sentence_data']['地形']['wrong_3'] = 
					$quiz_data['wrong_data'][3]['地形']['wrong'];
				}

			}elseif($key == '県の鳥'){
				if(!empty($quiz_data['wrong_data'][1]['県の鳥'])){
					$quiz_data['sentence_data']['県の鳥']['wrong_1'] = 
					$quiz_data['wrong_data'][1]['県の鳥']['wrong'];
				}
				if(!empty($quiz_data['wrong_data'][2]['県の鳥'])){
					$quiz_data['sentence_data']['県の鳥']['wrong_2'] = 
					$quiz_data['wrong_data'][2]['県の鳥']['wrong'];
				}
				if(!empty($quiz_data['wrong_data'][3]['県の鳥'])){
					$quiz_data['sentence_data']['県の鳥']['wrong_3'] = 
					$quiz_data['wrong_data'][3]['県の鳥']['wrong'];
				}
			}elseif($key == '県の木'){
				if(!empty($quiz_data['wrong_data'][1]['県の木'])){
					$quiz_data['sentence_data']['県の木']['wrong_1'] = 
					$quiz_data['wrong_data'][1]['県の木']['wrong'];
				}
				if(!empty($quiz_data['wrong_data'][2]['県の木'])){
					$quiz_data['sentence_data']['県の木']['wrong_2'] = 
					$quiz_data['wrong_data'][2]['県の木']['wrong'];
				}
				if(!empty($quiz_data['wrong_data'][3]['県の木'])){
					$quiz_data['sentence_data']['県の木']['wrong_3'] = 
					$quiz_data['wrong_data'][3]['県の木']['wrong'];
				}
			}elseif($key == '県の花'){
				if(!empty($quiz_data['wrong_data'][1]['県の花'])){
					$quiz_data['sentence_data']['県の花']['wrong_1'] = 
					$quiz_data['wrong_data'][1]['県の花']['wrong'];
				}
				if(!empty($quiz_data['wrong_data'][2]['県の花'])){
					$quiz_data['sentence_data']['県の花']['wrong_2'] = 
					$quiz_data['wrong_data'][2]['県の木']['wrong'];
				}
				if(!empty($quiz_data['wrong_data'][3]['県の花'])){
					$quiz_data['sentence_data']['県の花']['wrong_3'] = 
					$quiz_data['wrong_data'][3]['県の花']['wrong'];
				}
			}
		}
		return $quiz_data['sentence_data'];
	}
}
?>






















