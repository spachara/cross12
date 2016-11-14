<?php

class page_split 
{
	var $var_pageSize;
	var $var_currentPage;
	var $var_totalPage;
	var $var_file;

	function page_split($pagesize=10, $file="",$page=1){
		$this->var_pageSize=$pagesize;
		$this->var_currentPage=$page;
		$this->var_file=$file;
	}

	function _setPageSize($size=10){
		$this->var_pageSize=$size;
	}

	function _setPage($page=1){
		if(empty($page)) $page=1;
		$this->var_currentPage=$page;
	}

	function _setFile($file=""){
		$this->var_file=$file;
	}

	function _query($sql)
	{
		$result=mysql_query($sql);
		$num=mysql_num_rows($result);
		$rt = $num%$this->var_pageSize;
				
		$this->var_totalPage = ($rt!=0) ? ceil($num/$this->var_pageSize) : floor($num/$this->var_pageSize); 
		$goto = ($this->var_currentPage - 1) * $this->var_pageSize;

		$sql .= " LIMIT $goto , ".$this->var_pageSize;
		$result=mysql_query($sql);

		return $result;
	}

	function _displayPage($option="",$align="left")
	{
		$option = ($option == '&' ? '': $option) ; 
		echo "<div class='show-page_number-left'>Page no.  ";
		if($this->var_currentPage >1 && $this->var_currentPage<=$this->var_totalPage) {
			$prevpage = $this->var_currentPage - 1;
			echo "<a href='".$this->var_file."?page=".$prevpage.($_GET['id'] != '' ? "&id=".$_GET['id'] : "").($_GET['select_search'] != '' ? "&select_search=".$_GET['select_search'] : "").($_GET['search_text'] != '' ? "&search_text=".$_GET['search_text'] : "").$option."'><img src='images/back.png' border=0 align=absmiddle></a>\n";
		}

		echo " <b>".$this->var_currentPage."/".$this->var_totalPage."</b> ";

		if($this->var_currentPage != $this->var_totalPage) {
			$nextpage = $this->var_currentPage + 1;
			echo "<a href='".$this->var_file."?page=".$nextpage.($_GET['id'] != '' ? "&id=".$_GET['id'] : "").($_GET['select_search'] != '' ? "&select_search=".$_GET['select_search'] : "").($_GET['search_text'] != '' ? "&search_text=".$_GET['search_text'] : "").$option."'><img src='images/next.png' border=0 align=absmiddle></a>\n";
		}
		echo "</div>";

		$b=floor($this->var_currentPage/10); 
		$c=(($b*10));

		if($c>1) {
			$prevpage = $c-1;
			echo "<div class='listNumberPage'><a href='".$this->var_file."?page=".$prevpage.($_GET['id'] != '' ? "&id=".$_GET['id'] : "").($_GET['select_search'] != '' ? "&select_search=".$_GET['select_search'] : "").($_GET['search_text'] != '' ? "&search_text=".$_GET['search_text'] : "").$option."'>
			<img src='images/back.png' border=0 align=absmiddle></a></div>";
		}else{
			echo "<div class='listNumberPage'><img src='images/back-not.png'/></div>";
		}
				
				
						for($i=$c; $i<$this->var_currentPage ; $i++) {
							if($i>0)
							echo "<div class='listNumberPage'><a href='".$this->var_file."?page=".$i.($_GET['id'] != '' ? "&id=".$_GET['id'] : "").($_GET['select_search'] != '' ? "&select_search=".$_GET['select_search'] : "").($_GET['search_text'] != '' ? "&search_text=".$_GET['search_text'] : "").$option."'>$i</a></div> ";
						}

						echo "<div class='listNumberPage'>".$this->var_currentPage."</div>";

						for($i=($this->var_currentPage+1); $i<($c+10) ; $i++) {
							if($i<=$this->var_totalPage)
							echo "<div class='listNumberPage'><a href='".$this->var_file."?page=".$i.($_GET['id'] != '' ? "&id=".$_GET['id'] : "").($_GET['select_search'] != '' ? "&select_search=".$_GET['select_search'] : "").($_GET['search_text'] != '' ? "&search_text=".$_GET['search_text'] : "").$option."'>$i</a></div> ";
						}
			if($c>=0) {
				if(($c+10)<=$this->var_totalPage){
					$nextpage = $c+10;
					echo "<div class='listNumberPage'>
					<a href='".$this->var_file."?page=".$nextpage.($_GET['id'] != '' ? "&id=".$_GET['id'] : "").($_GET['select_search'] != '' ? "&select_search=".$_GET['select_search'] : "").($_GET['search_text'] != '' ? "&search_text=".$_GET['search_text'] : "").$option."'><img src='images/next.png' border=0 align=absmiddle></a></div>";
				}else{
			echo "<div class='listNumberPage'><img src='images/next-not.png'/></div>";
				}
			}
			else{
				//echo ">>\n";
			}


}
}


?>

