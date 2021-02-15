<script type="text/javascript">
	
const surveyAnalysis = [
	{QUESTION: "What Gender do you currently live as in your day to day life", OFFICE: "GM", CHOICE: "No Answer", TOTAL: "1"},
	{QUESTION: "What Gender do you currently live as in your day to day life", OFFICE: "GM", CHOICE: "Male", TOTAL: "6"},
	{QUESTION: "What Gender do you currently live as in your day to day life", OFFICE: "GM", CHOICE: "Both male and female", TOTAL: "3"},
	{QUESTION: "What Gender do you currently live as in your day to day life", OFFICE: "SAGM", CHOICE: "No Answer", TOTAL: "1"},
	{QUESTION: "What Gender do you currently live as in your day to day life", OFFICE: "SAGM", CHOICE: "Male", TOTAL: "1"},
	{QUESTION: "What Gender do you currently live as in your day to day life", OFFICE: "AGMO", CHOICE: "Male", TOTAL: "1"},
	{QUESTION: "What Gender do you currently live as in your day to day life", OFFICE: "AGMO", CHOICE: "Both male and female", TOTAL: "3"},
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

// Scan
// check if 

// const dataToReturn = [{
// 	title: "What Gender do you currently live as in your day to day life",
// 	labels: ["GM","SAGM","AGMO"],
// 	datasets: [{
// 		label: "No Answer",
// 		data: [1,1],
// 		backgroundColor: 'rgb'
// 	},{
// 		label: "Male",
// 		data: [6,1,1],
// 		backgroundColor: 'rgb'
// 	},{
// 		label: "Both Male and Female",
// 		data: [3,3],
// 		backgroundColor: 'rgb'
// 	}]
// },{
// 	title: "How do you describe yourself",
// 	labels: ["GM","SAGM","AGMO"],
// 	datasets: [{
// 		label: "No Answer",
// 		data: [1,1],
// 		backgroundColor: 'rgb'
// 	},{
// 		label: "Male",
// 		data: [6,1,1],
// 		backgroundColor: 'rgb'
// 	},{
// 		label: "Both Male and Female",
// 		data: [3,3],
// 		backgroundColor: 'rgb'
// 	}]
// }];


let surveyAnalysisKeyList = [];

const newSurveyAnalysis = surveyAnalysis.reduce( (allSurveyAnalysis, surveyAnalysis) => {

	// console.log(surveyAnalysis.QUESTION);
	let index = surveyAnalysisKeyList.indexOf(surveyAnalysis.QUESTION);        
	// let choices = [];

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

console.log(newSurveyAnalysis);

const results = [];

for (let i = 0; i < newSurveyAnalysis.length; i++) 
{
	let datasetsArr = [];

	// console.log(newSurveyAnalysis[i].CHOICE);

	// for (let o = 0; o < newSurveyAnalysis[i].OFFICE.length - 1; o++) {
	
	// 	if (newSurveyAnalysis[i].OFFICE[o] == newSurveyAnalysis[i].OFFICE[o + 1]) {
		
	// 		console.log(newSurveyAnalysis[i].OFFICE[o]);

	// 	}

	// }

	for (let c = 0; c < newSurveyAnalysis[i].CHOICE.length; c++) {
		
		// console.log(newSurveyAnalysis[i].CHOICE[c]);

		datasetsArr.push({
			label: newSurveyAnalysis[i].CHOICE[c],
			data: [],
			backgroundColor: 'rgb'
		});

	}

	// console.log(datasetsArr);

	results.push({
		title: newSurveyAnalysis[i].QUESTION,
		labels: newSurveyAnalysis[i].OFFICE,
		// datasets: datasetsArr
		datasets: [{
			label: "No Answer",
			data: [1,1],
			backgroundColor: 'rgb'
		},{
			label: "Male",
			data: [6,1,1],
			backgroundColor: 'rgb'
		},{
			label: "Both Male and Female",
			data: [3,3],
			backgroundColor: 'rgb'
		}]
	});
}

// console.log(results);

// const testArr = ["No Answer", "Male", "Both male and female", "No Answer", "Male", "Male", "Both male and female"];

// console.log(testArr.splice(0,4));

const rawData = [{
	choices: ["No Answer", "Male", "Both male and female", "No Answer", "Male", "Male", "Both male and female"],
	totals: ["1", "6", "3", "1", "1", "1", "3"]
}];

const convertedData = [];
const scannedData = [];
const totalsArr = [];

for (i in rawData) {

	for (let c = 0; c < rawData[i].choices.length; c++) {

		if (scannedData.includes(rawData[i].choices[c])) {
			// totalsArr.push(rawData[i].totals[c]);
			// console.log(c)
		}
		else {
			scannedData.push(rawData[i].choices[c]);

			// console.log(c)

			// totalsArr.push(rawData[i].totals[c]);
			convertedData.push({
				label: rawData[i].choices[c],
				data: totalsArr,
			})
		}
	}
}

// console.log(convertedData);



</script>