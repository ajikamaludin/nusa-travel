import React, { useEffect, useRef } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import FormInput from '@/Components/FormInput';
import Button from '@/Components/Button';
import { Head, useForm } from '@inertiajs/react';
import FormFile from '@/Components/FormFile';

import { CKEditor } from '@ckeditor/ckeditor5-react';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

import { useQuill } from 'react-quilljs';
import 'react-quill/dist/quill.snow.css';
import BlotFormatter from 'quill-blot-formatter';

import TinyEditorComponent from '@/Components/TinyMCE';


export default function Payment(props) {
  const { quill, quillRef , Quill} = useQuill({
    modules: { blotFormatter: {} }
  });

    const {data, setData, post, processing, errors} = useForm({
        title: '',
        body: '',
        image: '',
        tags: [],
        is_publish: 0
    })

    if (Quill && !quill) {
      // const BlotFormatter = require('quill-blot-formatter');
      Quill.register('modules/blotFormatter', BlotFormatter);
    }

    function uploadAdapter(loader) {
        return {
          upload: () => {
            return new Promise((resolve, reject) => {
              const body = new FormData();
              loader.file.then((file) => {
                body.append("_token", props.csrf_token);
                body.append("image", file);

                fetch(route('post.upload'), {
                  method: "post",
                  body: body,
                  headers: {
                    'accept-content': 'application/json',
                    'X-CSSRF-TOKEN': props.csrf_token
                  },
                  credentials: 'include'
                })
                  .then((res) => res.json())
                  .then((res) => {
                    resolve({
                      default: res.url
                    });
                  })
                  .catch((err) => {
                    reject(err);
                  });
              });
            });
          }
        };
      }

    function uploadPlugin(editor) {
      editor.plugins.get("FileRepository").createUploadAdapter = (loader) => {
        return uploadAdapter(loader);
      };
    }

    const handleOnChange = (event) => {
        setData(event.target.name, event.target.type === 'checkbox' ? (event.target.checked ? 1 : 0) : event.target.value);
    }

    const handleChange = (e) => {
        setData("body", e)
    }

    const handleSubmit = () => {
        post(route('post.store'))
    }

    // Insert Image(selected by user) to quill
  const insertToEditor = (url) => {
    const range = quill.getSelection();
    quill.insertEmbed(range.index, 'image', url);
  };

  // Upload Image to Image Server such as AWS S3, Cloudinary, Cloud Storage, etc..
  const saveToServer = async (file) => {
    const body = new FormData();
    body.append("_token", props.csrf_token);
    body.append("image", file);

    await fetch(route('post.upload'), {
      method: "post",
      body: body,
      headers: {
        'accept-content': 'application/json',
        'X-CSSRF-TOKEN': props.csrf_token
      },
      credentials: 'include'
    }).then(res => res.json())
    .then(res => insertToEditor(res.url))
  };

  // Open Dialog to select Image File
  const selectLocalImage = () => {
    const input = document.createElement('input');
    input.setAttribute('type', 'file');
    input.setAttribute('accept', 'image/*');
    input.click();

    input.onchange = () => {
      const file = input.files[0];
      saveToServer(file);
    };
  };

  React.useEffect(() => {
    if (quill) {
      // Add custom handler for Image Upload
      quill.getModule('toolbar').addHandler('image', selectLocalImage);
    }
  }, [quill]);

  useEffect(() => {
    if (quill) {
      quill.on('text-change', (delta, oldDelta, source) => {
        console.log(quill.root.innerHTML); // Get innerHTML using quill
      });
    }
  }, [quill])

  const editorRef = useRef(null);
  const log = () => {
    if (editorRef.current) {
      console.log(editorRef.current.getContent());
    }
  };

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={"Setting"}
            action={"Payment"}
        >
            <Head title="Payment" />

            <div>
                <div className="mx-auto sm:px-6 lg:px-8">
                    <div className="overflow-hidden p-4 shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 flex flex-col">
                        <div className='text-xl font-bold mb-4'>Post</div>
                        <FormInput
                            name="title"
                            value={data.title}
                            onChange={handleOnChange}
                            label="Title"
                            error={errors.title}
                        />
                        <FormFile
                                label={'Cover Image'}
                                onChange={e => setData('image', e.target.files[0])}
                                error={errors.image}
                            />
                        {/* <CKEditor
                            config={{
                                extraPlugins: [uploadPlugin],
                            }}
                            editor={ClassicEditor}
                            data={data.body}
                            onReady={(editor) => {}}
                            onBlur={(event, editor) => {}}
                            onFocus={(event, editor) => {}}
                            onChange={(event, editor) => {
                                handleChange(editor.getData());
                            }}
                        /> */}
                        {/* <div className='pb-10' style={{ width: '100hs', height: '500px', border: '1px solid lightgray' }}>
                          <div ref={quillRef} />
                        </div> */}
                        <TinyEditorComponent
                        onInit={(evt, editor) => editorRef.current = editor}
                        initialValue='<p>This is the initial content of the editor.</p>'
                        init={{
                          height: 500,
                          menubar: false,
                          plugins: [
                            'advlist', 'anchor', 'autolink', 'help', 'image', 'link', 'lists',
                            'searchreplace', 'table', 'wordcount'
                          ],
                          toolbar: 'undo redo | blocks | ' +
                            'bold italic forecolor | alignleft aligncenter ' +
                            'alignright alignjustify | bullist numlist outdent indent | ' +
                            'removeformat | help image',
                          content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
                          file_picker_callback: async (callback, value, meta) => {
                            // Provide file and text for the link dialog
                            if (meta.filetype == 'file') {
                              callback('mypage.html', { text: 'My text' });
                            }
                        
                            // Provide image and alt text for the image dialog
                            if (meta.filetype == 'image') {
                              // const body = new FormData();
                              // body.append("_token", props.csrf_token);
                              // body.append("image", meta.file);

                              // await fetch(route('post.upload'), {
                              //   method: "post",
                              //   body: body,
                              //   headers: {
                              //     'accept-content': 'application/json',
                              //     'X-CSSRF-TOKEN': props.csrf_token
                              //   },
                              //   credentials: 'include'
                              // }).then(res => res.json())
                              // .then(res => {
                              //   callback(res.url, { alt: 'My alt text' });
                              // })
                              callback('imge.jprg', { text: 'My text' });
                              
                            }
                        
                            // Provide alternative source and posted for the media dialog
                            if (meta.filetype == 'media') {
                              callback('movie.mp4', { source2: 'alt.ogg', poster: 'image.jpg' });
                            }
                          }
                        }}
                />
                        <div className='mt-2'>
                            <Button
                                onClick={handleSubmit}
                                processing={processing} 
                            >
                                Simpan
                            </Button>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}