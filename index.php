<?php
    /* "My Stuff" to invoke */

    function scaryIntent() {
        $responses = Array(
            "<emphasis level='strong'><prosody pitch='low'>I see dead people</prosody></emphasis>",
            "<emphasis level='strong'><prosody pitch='low'>Turn around</prosody></emphasis>",
            "I begin tucking him into bed and he tells me, daddy check for monsters under my bed. I look underneath for his amusement and see him, another him, under the bed, staring back at me quivering and whispering, <emphasis level='strong'>Daddy there is somebody on my bed.</emphasis>",
            "Don't be scared of the monsters, just look for them. Look to your left, to your right, under your bed, behind your dresser, in your closet,<break time='1s' /> but never look up, she hates being seen.",
            "I woke up to hear knocking on glass.  At first, I though it was the window until I heard it come from the mirror again.",
            "I just saw my reflection blink.",
            "The last man on Earth sat alone in a room. There was a knock at the door.",
            "You hear your mom calling you into the kitchen. As you are heading down the stairs you hear a whisper from the closet saying, don’t go down there honey, I heard it too.",
            "The longer I wore it the more it grew on me.  She had such pretty skin.",
            "Growing up with cats and dogs, I got used to the sounds of scratching at my door while I slept. Now that I live alone, it is <emphasis level='strong'>much more unsettling</emphasis>.",
            "You know that weird, full-body twitch you get sometimes when you’re falling asleep? If there was a camera pointed at you, and you saw what it captured at that moment, you’d never sleep again.",
            "<emphasis level='strong'><prosody pitch='low'>I see dead people</prosody></emphasis>",
            "<emphasis level='strong'><prosody pitch='low'>Turn around</prosody></emphasis>",
            "Last winter, my neighbors built the creepiest snowman I’ve ever seen. It got even creepier when I saw it standing in front of my house, staring through my living room window, in the middle of July.",
            "Do the voices in your head say you're not crazy either?",
            "Last night I was woken up in the middle of the night by the sounds of a girl crying. I'm too scared to let her out.",
            "As I opened the fridge in the middle of the night, my heart sank and I felt like fainting. It was completely empty.",
            "She adored pink to the point the entire house was so. The walls, the furniture, the silverware, and even the bodies.",
            "I don't know what's more unsettling: The fact that my TV wakes me up at night, or the fact that it's been unplugged for over a month."
        );

        return "Okay, here's something creepy. <break time='1s' /><amazon:effect name='whispered'>".$responses[array_rand($responses)]."</amazon:effect>";
    }

    function helloIntent($name = '') {
        if($name == 'your master') {
            return 'Hello my lord';
        }
        $greetings = Array(
            'Hi',
            'Hello',
            'Howdy',
            'Hey',
            'Yo',
            'Hows it going',
            'Whats up'
        );
        return $greetings[array_rand($greetings)]." ".$name."!";
    }
    function helpIntent() {
        return "Here's a list of commands you can use: help, say hello, rick roll, say something creepy";
    }
    function rickRollIntent() {
        return "<break time='1s' /><audio src='https://dev.md5.xyz/alexa/rickroll.mp3' />";
    }

    function composeSSML($ssml) {
        return '{
            "version": "string",
            "sessionAttributes": {
                "key": "value"
            },
            "response": {
                "outputSpeech": {
                "type": "SSML",
                "ssml": "<speak>'.$ssml.'</speak>"
                },
                "shouldEndSession": true
            }
        }';
    }

    $post = json_decode(file_get_contents('php://input'));
    if($post->request->type == 'IntentRequest') {
        if($post->request->intent->name == 'scaryIntent') {
            die(composeSSML(
                scaryIntent()
            ));
        } else if($post->request->intent->name == 'helloIntent') {
            if(!isset($post->request->intent->slots->name->value)) {
                die(composeSSML(
                    helloIntent()
                ));
            } else {
                die(composeSSML(
                    helloIntent($post->request->intent->slots->name->value)
                ));
            }
        } else if($post->request->intent->name == 'AMAZON.HelpIntent') {
            die(composeSSML(
                helpIntent()
            ));
        } else if($post->request->intent->name == 'rickRollIntent') {
            die(composeSSML(
                rickRollIntent()
            ));
        } else {
            die(composeSSML("I don't know how to do that."));
        }
    }
        
?>
