<script type="text/javascript">

// This would be a good opportunity to use the reduce function.

// What we do is cycle through each of the original recipients list, see if we have already processed the element, if we have, append the task of the current element to the already processed element, otherwise, add the current recipient to the processed list

// original array
var recipients = [
    {name: 'Michael',task:'programming',contactdetails:'michael@michael.com'},
    {name: 'Michael',task:'eating',contactdetails:'michael@michael.com'},
    {name: 'Michael',task:'cooking',contactdetails:'michael@michael.com'},
    {name: 'Shane',task:'designing',contactdetails:'shane@shane.com'},
    {name: 'Angelo',task:'sda',contactdetails:'angelo@angelo.com'},
    {name: 'Angelo',task:'gfdg',contactdetails:'angelo@angelo.com'},
    {name: 'Angelo',task:'jgh',contactdetails:'angelo@angelo.com'},
    {name: 'Angelo',task:'jkh',contactdetails:'angelo@angelo.com'},
    {name: 'Angelo',task:'ljk',contactdetails:'angelo@angelo.com'},
];

let recipientKeyList = []; // used to store the contacts we've already processed
// cycle through each recipient element

const newRecipients = recipients.reduce(function(allRecipients, recipient){
    
    // get the indexOf our processed array for the current recipient
    let index = recipientKeyList.indexOf(recipient.name);

    // if the name already exist, append the task
    if(index >= 0) {

        let task = allRecipients[index].task + ', ' + recipient.task;

        allRecipients[index].task = task.split(",");

        return allRecipients;
    }
    else { // otherwise append the recipient
        
        recipientKeyList.push(recipient.name)
        
        return allRecipients.concat(recipient);
    }

}, []);

console.log(newRecipients);

</script>