<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Blackbag Scribe</title>
  <style>
    .error { color: red; }
    .mic-status.active { color: green; }
    .mic-status.error { color: red; }
    .mic-status.idle { color: gray; }
  </style>
</head>
<body>
  <h1>Blackbag Scribe</h1>

  <button id="recordButton">Start Transcription</button>
  <div class="mic-status idle" id="micStatus">Idle</div>
  <div class="error" id="errorMsg"></div>

  <h2>Transcription:</h2>
  <div id="transcriptionBox">No transcription yet...</div>

  
  <script type="module">
    import {
  TranscribeStreamingClient,
  StartMedicalStreamTranscriptionCommand
} from "{{assets('js/scribe.js')}}";

    let isRecording = false;
    let audioContext, source, processor, stream;
    let audioQueue = [];
    let isStreaming = false;
    let client;
      
      let transcription = '';
    const recordBtn = document.getElementById('recordButton');
    //const micStatus = document.getElementById('micStatus');
    const transcriptionBox = document.getElementById('transcriptionBox');
    const errorMsg = document.getElementById('errorMsg');

    async function initAWS() {
      const accessKeyId = @json(env('AWS_ACCESS_KEY_PRIVATE_ID_SCRIBE'));
      const secretAccessKey = @json(env('AWS_SECRET_PRIVATE_ACCESS_KEY_SCRIBE'));
      const region = @json(env('AWS_DEFAULT_REGION'));

      client = new TranscribeStreamingClient({
        region,
        credentials: {
          accessKeyId,
          secretAccessKey
        }
      });
    }

    async function startRecording() {
      if (!client) {
        errorMsg.textContent = 'AWS client not initialized';
        return;
      }

    
      stream = await navigator.mediaDevices.getUserMedia({ audio: true });
      audioContext = new AudioContext({ sampleRate: 16000 });
      source = audioContext.createMediaStreamSource(stream);
      processor = audioContext.createScriptProcessor(4096, 1, 1);

      source.connect(processor);
      processor.connect(audioContext.destination);

      isStreaming = true;
      audioQueue = [];

     processor.onaudioprocess = async e => {
          const inputBuffer = e.inputBuffer;

          // Resample to 16000 Hz
          const newBuffer = await resampleTo16kHz(inputBuffer);
          const resampledData = newBuffer.getChannelData(0);

          const pcmData = new Int16Array(resampledData.length);
          for (let i = 0; i < resampledData.length; i++) {
            pcmData[i] = Math.max(-32768, Math.min(32767, resampledData[i] * 32767));
          }

          audioQueue.push(new Uint8Array(pcmData.buffer));
        };


      recordBtn.classList.add('audiostartcls');

      startTranscribeStream();
    }
    async function resampleTo16kHz(audioBuffer) {
      const offlineCtx = new OfflineAudioContext(1, 16000 * audioBuffer.duration, 16000);
      const source = offlineCtx.createBufferSource();
      source.buffer = audioBuffer;
      source.connect(offlineCtx.destination);
      source.start(0);
      return await offlineCtx.startRendering();
    }

    async function startTranscribeStream() {
        try{
      const command = new StartMedicalStreamTranscriptionCommand({
        LanguageCode: "en-US",
        MediaEncoding: "pcm",
        MediaSampleRateHertz: 16000,
        Specialty: "PRIMARYCARE",
        Type: "DICTATION",
        AudioStream: {
          async *[Symbol.asyncIterator]() {
            while (isStreaming) {
              if (audioQueue.length > 0) {
                const chunk = audioQueue.shift();
                yield { AudioEvent: { AudioChunk: chunk } };
              } else {
                await new Promise(resolve => setTimeout(resolve, 10));
              }
            }
          }
        }
      });

      
        const response = await client.send(command);
          
          if (response.TranscriptResultStream) {
              let finalText = '';
              for await (const event of response.TranscriptResultStream) {
                if (!isStreaming) break;
                const transcript = event.TranscriptEvent?.Transcript;
                if (transcript?.Results?.length > 0) {
                  const result = transcript.Results[0];
                  if (result.IsPartial) {
                    const partial = result.Alternatives[0]?.Transcript;
                    if (partial) {
                      setTranscription(`${finalText} ${partial}`.trim());
                    }
                  } else {
                    const final = result.Alternatives[0]?.Transcript;
                    if (final) {
                      finalText += (finalText ? ' ' : '') + final;
                      setTranscription(finalText);
                    }
                  }
                }
              }

        }
      } catch (err) {
            errorMsg.textContent = 'AWS Transcribe error: ' + err.message;
            //setError(`Recording error: ${err.message}`);
            stopRecording();
          }
    }
    const setTranscription = (text) => {
      transcription = text;
      transcriptionBox.textContent = text || 'No transcription yet...';
    };
    function stopRecording() {
      isStreaming = false;
      //recordBtn.textContent = 'Start Transcription';
//      micStatus.className = 'mic-status idle';
//      micStatus.textContent = 'Idle';
          recordBtn.classList.remove('audiostartcls');
      if (processor) {
        processor.disconnect();
        processor = null;
      }
      if (source) {
        source.disconnect();
        source = null;
      }
      if (audioContext) {
        audioContext.close();
        audioContext = null;
      }
      if (stream) {
        stream.getTracks().forEach(t => t.stop());
        stream = null;
      }
    }

    recordBtn.onclick = () => {
      if (!isRecording) {
        isRecording = true;
        initAWS().then(startRecording);
      } else {
        isRecording = false;
        stopRecording();
      }
    };
  </script>
</body>
</html>
