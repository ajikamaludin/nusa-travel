export const FileUploader = async (callback, csrf_token) => {
    // Provide file and text for the link dialog
    const input = document.createElement("input");
    input.setAttribute("type", "file");
    input.setAttribute("accept", "image/*,video/*");

    input.addEventListener("change", async (e) => {
        const body = new FormData();
        body.append("_token", csrf_token);
        body.append("image", e.target.files[0]);

        await fetch(route("post.upload"), {
            method: "post",
            body: body,
            headers: {
                "accept-content": "application/json",
                "X-CSSRF-TOKEN": csrf_token,
            },
            credentials: "include",
        })
            .then((res) => res.json())
            .then((res) => {
                callback(res);
            })
            .catch((err) => {
                alert(err);
            });
    });

    input.click();
};
