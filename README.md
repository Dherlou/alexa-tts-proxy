<p align="center">
  <h3 align="center">Alexa TTS Proxy API</h3>

  <p align="center">
    Proxy api for providing custom endpoints for Alexa TTS use cases.
    <br />
    <br />
    <a href="https://www.luckev.info/alexa-tts">My personal installation of this project</a>
    ·
    <a href="https://github.com/Dherlou/alexa-tts/issues">Report Bug</a>
    ·
    <a href="https://github.com/Dherlou/alexa-tts/issues">Request Feature</a>
  </p>
</p>



<!-- ABOUT THE PROJECT -->
## About The Project

Proxy api for providing custom endpoints for Alexa TTS use cases:
- Jenkins Job Notifications (pass job run parameters and it dispatches a formatted announcement)
- HomeAssistant Notifications (TBD)
- Custom Notifications (directly provide the text to be announced)



<!-- GETTING STARTED -->
## Getting Started

To get a local copy up and running follow these simple steps.

### Current build status:
My personal installation:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[![Build Status](https://luckev.info/jenkins/buildStatus/icon?job=Projects%2FAlexaTTS%2FBuild%2BDeploy)](https://luckev.info/jenkins/job/Projects/job/AlexaTTS/job/Build+Deploy/)

### Prerequisites

All you need is [Docker](https://www.docker.com/) as well as [Git](https://git-scm.com/)!

### Installation

Once docker is installed, you must follow these steps:

1. Alexa Setup
   1. Activate the skills [Text Vorlesen](https://www.amazon.de/Michael-Dworkin-Text-vorlesen/dp/B09MW253S4) and [Webhook Routine Trigger](https://www.amazon.de/Michael-Dworkin-Webhook-Routine-Trigger/dp/B09RGPYHLL) in your Alexa and follow the skills' setup instructions.
   2. Open the skills' administration pages (i.e. https://esp8266-server.de/alexa/TextVorlesen/ and https://trigger.esp8266-server.de/ respectively) and note down the `id` and `hash` parmaeter of both skill sessions, which can be found in the sample links.
2. Set up your environment, which will serve this API:
   1. Clone this repository.
    ```sh
    git clone https://github.com/Dherlou/alexa-tts
    ```
   2. Create your `secrets.json`:
      1. Copy the `secrets.template.json` to a location where you store your credential files and rename it to `secrets.json`.
      2. Update the content of this file by pasting the previously noted `id` and `hash` values of each skill.
      3. Create a php password hash with [password_hash](https://www.php.net/manual/en/function.password-hash.php) and paste the resulting hash in the webhook hash field.
      4. Create an environment variable `ALEXA_TTS_SECRETS` which points to the directory in which your `secrets.json` file is located.
   3. Start the docker run:
      * production version:
        ```sh
        docker-compose up -d
        ```
      * **or** development version (mounts repository into the container and doesn't verify tls for local setups):
        ```sh
        docker-compose -f docker-compose.yml -f docker-compose-local.yml up -d
        ```


<!-- USAGE EXAMPLES -->
## Usage

Once docker is running, you can make API calls from arbitrary scripts/sources.
You can use the endpoints for the different scenarios (e.g. `/scenarios/jenkins.php`) or the generic one at `/index.php`.
For authentication against your proxy api, you have to add the header `X-WEBHOOK-SECRET` with the plaintext password used while creating the php password hash during the environment setup as the header's value.
Further payload depends on the given scenario. The generic endpoint expects the text as a POST parameter, whereas the Jenkins scenario expects a json encoded body with the required data. Check the code for your use case.



<!-- ROADMAP -->
## Roadmap

* implement endpoint for HomeAssistant notifications
* feel free to contribute further endpoints or improve existing ones for your required services


<!-- LICENSE -->
## License

Distributed under the GNU Affero General Public License. See [LICENSE](./LICENSE) for more information.



<!-- CONTACT -->
## Contact

Lucas Kinne - lucas@luckev.info

Project Link: https://github.com/Dherlou/alexa-tts



<!-- ACKNOWLEDGEMENTS -->
## Acknowledgements

Special thanks to Michael Dworkin for developing and providing the Alexa skills [Text Vorlesen](https://www.amazon.de/Michael-Dworkin-Text-vorlesen/dp/B09MW253S4) and [Webhook Routine Trigger](https://www.amazon.de/Michael-Dworkin-Webhook-Routine-Trigger/dp/B09RGPYHLL) that do the actual heavy lifting. Check out his skills and leave a positive rating, if the skills are helpful to you. :)
