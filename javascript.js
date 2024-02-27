// send post request
async function getData() {

        try {

            let countryName = document.querySelector('#countryList').value;
            const response = await fetch("{{url('county-info')}}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-Token": "{{csrf_token()}}"
                },
                body: JSON.stringify({nicname: countryName}),
            });

            const result = await response.json();
            console.log('Response', result)
        } catch (error) {
            console.error("Error:", error);
        }
    }
