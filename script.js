var nameError = document.getElementById('data_in');

function validateName(){
	var name = 	;

	if(name.length == 0){
		nameError.innerHTML = 'Data is required';
		return false;
	}

	if(name <=$row['spec_usl'] && name >=$row['spec_lsl']){
		nameError.innerHTML = 'O';
		return true;
	}else{
		nameError.innerHTML = 'X';
		return false;
	}
}