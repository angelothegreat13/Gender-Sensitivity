<script type="text/javascript">

const surveyAnalysis = [
	{QUESTION: "What Gender do you currently live as in your day to day life", OFFICE: "GM", CHOICE: "No Answer", TOTAL: "1"},
	// {QUESTION: "What Gender do you currently live as in your day to day life", OFFICE: "GM", CHOICE: "Male", TOTAL: "6"},
	// {QUESTION: "What Gender do you currently live as in your day to day life", OFFICE: "GM", CHOICE: "Both male and female", TOTAL: "3"},
	// {QUESTION: "What Gender do you currently live as in your day to day life", OFFICE: "SAGM", CHOICE: "No Answer", TOTAL: "1"},
	// {QUESTION: "What Gender do you currently live as in your day to day life", OFFICE: "SAGM", CHOICE: "Male", TOTAL: "1"},
	// {QUESTION: "What Gender do you currently live as in your day to day life", OFFICE: "AGMO", CHOICE: "Male", TOTAL: "1"},
	// {QUESTION: "What Gender do you currently live as in your day to day life", OFFICE: "AGMO", CHOICE: "Both male and female", TOTAL: "3"},
	{QUESTION: "How do you describe yourself", OFFICE: "GM", CHOICE: "No Answer", TOTAL: "1"},
	{QUESTION: "How do you describe yourself", OFFICE: "GM", CHOICE: "Male", TOTAL: "7"},
	{QUESTION: "How do you describe yourself", OFFICE: "GM", CHOICE: "Bisexual", TOTAL: "2"},
	{QUESTION: "How do you describe yourself", OFFICE: "SAGM", CHOICE: "Male", TOTAL: "2"},
	{QUESTION: "How do you describe yourself", OFFICE: "AGMO", CHOICE: "Male", TOTAL: "2"},
	{QUESTION: "How do you describe yourself", OFFICE: "AGMO", CHOICE: "Bisexual", TOTAL: "1"},
	{QUESTION: "How do you describe yourself", OFFICE: "AGMO", CHOICE: "Transgender Woman", TOTAL: "1"},
	{QUESTION: "Are you ashamed of your sexuality", OFFICE: "GM", CHOICE: "No Answer", TOTAL: "1"},
	{QUESTION: "Are you ashamed of your sexuality", OFFICE: "GM", CHOICE: "Yes", TOTAL: "8"},
	{QUESTION: "Are you ashamed of your sexuality", OFFICE: "GM", CHOICE: "No", TOTAL: "1"},
	{QUESTION: "Are you ashamed of your sexuality", OFFICE: "SAGM", CHOICE: "Yes", TOTAL: "2"},
	{QUESTION: "Are you ashamed of your sexuality", OFFICE: "AGMO", CHOICE: "Yes", TOTAL: "3"},
	{QUESTION: "Are you ashamed of your sexuality", OFFICE: "AGMO", CHOICE: "No", TOTAL: "1"}
];

let surveyAnalysisKeyList = [];

const newSurveyAnalysis = surveyAnalysis.reduce( (allSurveyAnalysis, surveyAnalysis) => {

	let index = surveyAnalysisKeyList.indexOf(surveyAnalysis.QUESTION);        

    if (index >= 0) {

        let offices = allSurveyAnalysis[index].OFFICE + "," + surveyAnalysis.OFFICE;
        let choices = allSurveyAnalysis[index].CHOICE + "," + surveyAnalysis.CHOICE;
        let totals = allSurveyAnalysis[index].TOTAL + "," + surveyAnalysis.TOTAL;

        allSurveyAnalysis[index].OFFICE = [...new Set(offices.split(","))];

   		allSurveyAnalysis[index].CHOICE = choices.split(",");

        allSurveyAnalysis[index].TOTAL = totals.split(",");

        return allSurveyAnalysis
    }
    else { 

        surveyAnalysisKeyList.push(surveyAnalysis.QUESTION);

        return allSurveyAnalysis.concat(surveyAnalysis);
    }
    
},[]);

// console.log(newSurveyAnalysis);

const result = [];

for (i in newSurveyAnalysis) 
{
	let uniqueChoices = [];
	let choices = [];

	if (Array.isArray(newSurveyAnalysis[i].CHOICE)) {
		choices = newSurveyAnalysis[i].CHOICE;
		uniqueChoices = [...new Set(choices)];
	}
	else {
		choices.push(newSurveyAnalysis[i].CHOICE);
		uniqueChoices.push(choices);
	}

	let datasets = [];
		
	for (let j = 0; j < uniqueChoices.length; j++) {
		
		let totals = [];

		for (let k = 0; k < choices.length; k++) {
			if (choices[k] == uniqueChoices[j]) {
				totals.push(newSurveyAnalysis[i].TOTAL[k]);
			}
		}

		datasets.push({
			label: uniqueChoices[j],
			data: totals,
			backgroundColor : 'rgb'
		});	
	}		

	result.push({
		title: newSurveyAnalysis[i].QUESTION,
		labels: newSurveyAnalysis[i].OFFICE,
		datasets: datasets
	});
}

console.log(result);

// for (r in result) {

// 	chart = new Chart(ctx, {
//         type: 'bar',
//         data: {
//             labels: result[r].labels,
//             datasets: result[r].datasets
//         },
//         options: defaultBarChartOption(result[r].title,true,{
//             labels: false
//         })
//     });
// }


</script>