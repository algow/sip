from sms import constructContent
from sys import exit, argv
import gammu, json

loadMessage = json.loads(argv[1])
content = constructContent(loadMessage)

sm = gammu.StateMachine()
sm.ReadConfig()
sm.Init()

message = {
    'Text': content.message(),
    'SMSC': {'Location': 1},
    'Number': '+6281386351806',
}

sm.SendSMS(message)
