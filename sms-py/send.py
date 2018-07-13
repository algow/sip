from sms import sms
from sys import argv
import gammu, json

loadMessage = json.loads(argv[1])
content = sms(loadMessage)

sm = gammu.StateMachine()
sm.ReadConfig()
sm.Init()

message = {
    'Text': 'python-gammu testing message',
    'SMSC': {'Location': 1},
    'Number': '+6281386351806',
}

sm.SendSMS(message)
