 #!/usr/bin/python
import websocket
import thread
import time
import random
import json

num = random.randint(0,100)

print num

dato={'ok':random.randint(0,100),
'valorx':random.randint(0,100),
'valory':random.randint(0,100),
'teta':random.randint(0,100),
'q1':random.randint(0,100),
'q2':random.randint(0,100),
'q3':random.randint(0,100),
'q4':random.randint(0,100),
'ftang':random.randint(0,100),
'gnormal':random.randint(0,100)
}

print dato

