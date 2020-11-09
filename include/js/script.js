const Peer = window.Peer;


(async function main() {
  var queryString = window.location.search;
var queryObject = new Object();
if(queryString){
  queryString = queryString.substring(1);
  var parameters = queryString.split('&');

  for (var i = 0; i < parameters.length; i++) {
    var element = parameters[i].split('=');

    var paramName = decodeURIComponent(element[0]);
    var paramValue = decodeURIComponent(element[1]);

    queryObject[paramName] = paramValue;
  }
}
  const localVideo = document.getElementById('js-local-stream');
  const joinTrigger = document.getElementById('js-join-trigger');
  const leaveTrigger = document.getElementById('js-leave-trigger');
  const remoteVideos = document.getElementById('js-remote-streams');
  const roomMode = document.getElementById('js-room-mode');
  const localName = document.getElementById('js-local-Name');
  const localText = document.getElementById('js-local-text');
  const sendTrigger = document.getElementById('js-send-trigger');
  const messages = document.getElementById('js-messages');
  const meta = document.getElementById('js-meta');
  const alertmsg = document.getElementById('js-alertmsg');
  const sdkSrc = document.querySelector('script[src*=skyway]');
  meta.innerText = `
    UA: ${navigator.userAgent}
    SDK: ${sdkSrc ? sdkSrc.src : 'unknown'}
  `.trim();

  const getRoomModeByHash = 'sfu';

  roomMode.textContent = 'sfu';
  window.addEventListener(
    'hashchange',
    () => (roomMode.textContent = 'sfu')
  );

  const localStream = await navigator.mediaDevices
    .getUserMedia({
      audio: true,
      video: false,
    })
    .catch(console.error);

  // Render local stream
  localVideo.muted = true;
  localVideo.srcObject = localStream;
  localVideo.playsInline = true;
  await localVideo.play().catch(console.error);

  // eslint-disable-next-line require-atomic-updates
  const peer = (window.peer = new Peer({
    key: 'd12e2e45-21b0-4825-99ae-63442afdab51',
    debug: 3,
  }));

  // Register join handler
  joinTrigger.addEventListener('click', () => {
    // Note that you need to ensure the peer has connected to signaling server
    // before using methods of peer instance.
    if (!peer.open) {
      return;
    }

    const room = peer.joinRoom(queryObject.roomid, {
      mode: 'sfu',
      stream: localStream,
    });

    room.once('open', () => {
      messages.textContent += '=== You joined ===\n';
    });
    room.on('peerJoin', peerId => {
      messages.textContent += `=== ${peerId} joined ===\n`;
    });

    // Render remote stream for new peer join in the room
    room.on('stream', async stream => {
      const newVideo = document.createElement('video');
      newVideo.srcObject = stream;
      newVideo.playsInline = true;
      // mark peerId to find it later at peerLeave event
      newVideo.setAttribute('data-peer-id', stream.peerId);
      remoteVideos.append(newVideo);
      await newVideo.play().catch(console.error);
    });

    room.on('data', ({ data, src }) => {
      // Show a message sent to the room and who sent
      messages.textContent += `${src} ${data}\n`;
    });

    // for closing room members
    room.on('peerLeave', peerId => {
      const remoteVideo = remoteVideos.querySelector(
        `[data-peer-id="${peerId}"]`
      );
      remoteVideo.srcObject.getTracks().forEach(track => track.stop());
      remoteVideo.srcObject = null;
      remoteVideo.remove();

      messages.textContent += `=== ${peerId} left ===\n`;
    });

    // for closing myself
    room.once('close', () => {
      sendTrigger.removeEventListener('click', onClickSend);
      messages.textContent += '== You left ===\n';
      Array.from(remoteVideos.children).forEach(remoteVideo => {
        remoteVideo.srcObject.getTracks().forEach(track => track.stop());
        remoteVideo.srcObject = null;
        remoteVideo.remove();
      });
    });

    sendTrigger.addEventListener('click', onClickSend);
    leaveTrigger.addEventListener('click', () => room.close(), { once: true });

    function onClickSend() {
      // Send message to all of the peers in the room via websocket
      if(localName.value =="" && localText.value == ""){
        alertmsg.style.visibility="visible";
        alertmsg.textContent ='送信エラー：入力されていません';
      }else if(localName.value ==""){
        alertmsg.style.visibility="visible";
        alertmsg.textContent ='送信エラー：君の名は。';
      } else if( localText.value == ""){
        alertmsg.style.visibility="visible";
        alertmsg.textContent ='送信エラー：無を送信しようとするな';
      }else { 
        alertmsg.style.visibility="hidden";
        var sendmsg = localName.value + "：" + localText.value;
        room.send(sendmsg);
        
        messages.textContent += `${localName.value}: ${localText.value}\n`;
        localText.value = '';
      }

      
    }
  });

  peer.on('error', console.error);
})();