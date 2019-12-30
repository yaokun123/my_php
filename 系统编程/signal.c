#include <stdio.h>
#include <signal.h>
#include <stdlib.h>
#include <unistd.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <arpa/inet.h>


void sighandler(int signo)
{
        if (signo == SIGINT)
        {
                printf("捕获到了 SIGINT 信号\n");
        }
}


int main()
{
        if (signal(SIGINT, sighandler) == SIG_ERR)
        {
                printf("注册信号处理方法失败\n");
                exit(1);
        }
 
        int servfd = socket(AF_INET, SOCK_STREAM, 0);
 
        struct sockaddr_in servaddr, clientaddr;
        socklen_t st = sizeof(clientaddr);
 
        servaddr.sin_family = AF_INET;
        servaddr.sin_port = htons(8888);
        servaddr.sin_addr.s_addr = htonl(INADDR_LOOPBACK);
 
        bind(servfd, (struct sockaddr *)&servaddr, sizeof(servaddr));
 
        listen(servfd, 1024);
 
        while(1)
        {
                int connfd = accept(servfd, (struct sockaddr *)&clientaddr, &st);
                if (connfd > 0)
                {
                        printf("客户端连接到服务器: %d\n", connfd);
                }
        }
}
